<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlanRequest;
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

        $users = $subscriptions->map(function ($subscription) {
            $user = $subscription->user;

            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'status' => $subscription->status === 'active' ? 'Actif' : 'Inactif',
                'subscription' => $subscription->plan->name ?? 'Aucun',
                'joinDate' => $subscription->starts_at
                    ? Carbon::parse($subscription->starts_at)->format('d/m/Y')
                    : null,
                'lastActive' => $user->last_login_at
                    ? Carbon::parse($user->last_login_at)->diffForHumans()
                    : 'Inconnu',
            ];
        });
        return Inertia::render('SuperAdmin/SubscriptionManagement', [
            'plans' => SubscriptionPlan::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanRequest $request)
    {
        SubscriptionPlan::create($request->validated());
        return back()->with('success','Plan created');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanRequest $request, SubscriptionPlan $plan)
    {
        $plan->update($request->validated());
        return back()->with('success','Plan updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionPlan $plan)
    {
        $plan->delete();
        return back()->with('success','Plan deleted');
    }
}
