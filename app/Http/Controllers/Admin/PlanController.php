<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlanRequest;
use App\Models\ChatbotMessage;
use App\Models\ChatbotSession;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptions = Subscription::with(['user', 'plan'])->get();

        $stats = [
            'total' => Payment::where('status', 'paid')->sum('amount_cents'),

            'active' => $subscriptions->where('status', 'active')->count(),
            'inactive' => $subscriptions->where('status', 'inactive')->count(),

            'messages_percent' => ChatbotSession::count() > 0
                ? round(ChatbotSession::count() * 100 / ChatbotMessage::count(), 2)
                : 0,

            'anulet_percent' => Payment::where('status', 'cancelled')->count() > 0
                ? round(
                    Payment::where('status', 'paid')->sum('amount_cents') /
                        Payment::where('status', 'cancelled')->count() * 100,
                    2
                )
                : 0,
        ];

        $payments = Payment::with(['user', 'subscription', 'subscription.plan'])->get();

        $subscriptions = $payments->map(function ($payment) {
            $user = $payment->user;
            $subscription = $payment->subscription;




            return [
                'id' => $user->id,
                'user' => $user->name,
                'email' => $user->email,
                'plan' => $subscription->plan->name ?? 'Aucun',
                'status' => $subscription->status === 'active' ? 'Actif' : 'Inactif',
                'amount' => $payment->amount_cents ?? 'Aucun',
                'nextBilling' => $subscription->end_at
                    ? Carbon::parse($subscription->end_at)->format('d/m/Y')
                    : null,
                'duration' => 30,
                'paymentMethod' =>'Carte bancaire'
            ];
        });

        return Inertia::render('SuperAdmin/SubscriptionManagement', [
            'plans' => SubscriptionPlan::all(),
            'stats' => $stats,
            'subscriptions' => $subscriptions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanRequest $request)
    {
        SubscriptionPlan::create($request->validated());
        return back()->with('success', 'Plan created');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanRequest $request, SubscriptionPlan $plan)
    {
        $plan->update($request->validated());
        return back()->with('success', 'Plan updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionPlan $plan)
    {
        $plan->delete();
        return back()->with('success', 'Plan deleted');
    }
}
