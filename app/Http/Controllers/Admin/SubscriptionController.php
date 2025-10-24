<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotSession;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\StripeClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptionPlans = SubscriptionPlan::all();

        return Inertia::render('Web/SubscriptionPlan/Index', [
            'subscriptionPlans' => $subscriptionPlans
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function checkout(Request $request)
    {
        try {
            // ✅ Validate input
            $request->validate([
                'plan_id' => 'required|exists:subscription_plans,id',
            ]);

            // ✅ Retrieve subscription plan
            $subscriptionPlan = SubscriptionPlan::findOrFail($request->plan_id);

            // ✅ Initialize Stripe
            $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));

            // ✅ Create checkout session
            $checkout_session = $stripe->checkout->sessions->create([
                'line_items' => [[
                    'price_data' => [
                        'currency' => $subscriptionPlan->currency ?? 'usd',
                        'product_data' => [
                            'name' => $subscriptionPlan->name,
                        ],
                        'unit_amount' => $subscriptionPlan->price_cents * 100, // Stripe expects cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel', [], true),
            ]);

            // ✅ Create pending subscription
            $subscription = Subscription::create([
                'user_id' => Auth::id(),
                'subscription_plan_id' => $subscriptionPlan->id,
                'status' => 'past_due',
                'starts_at' => now(),
                'end_at' => now()->addDays(30),
                'provider' => 'stripe',
                'provider_ref' => $checkout_session->id,
            ]);

            // ✅ Create pending payment record
            Payment::create([
                'user_id' => Auth::id(),
                'subscription_id' => $subscription->id,
                'amount_cents' => $subscriptionPlan->price_cents,
                'currency' => $subscriptionPlan->currency ?? 'usd',
                'status' => 'pending',
                'provider' => 'stripe',
                'provider_ref' => $checkout_session->id,
                'meta' => json_encode($checkout_session),
            ]);

            // ✅ Return Stripe checkout URL to frontend
            return response()->json([
                'url' => $checkout_session->url
            ]);
        } catch (\Exception $e) {
            // Return JSON error for debugging on frontend
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            abort(400, 'Missing session ID.');
        }

        // Initialize Stripe
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            // Retrieve the session from Stripe
            $session = Session::retrieve($sessionId);
        } catch (\Exception $e) {
            return abort(404, 'Session not found.' . $e->getMessage());
        }

        // if (!$session || !$session->customer) {
        //     throw new NotFoundHttpException('Invalid session or missing customer.');
        // }

        // Retrieve the customer data
        $customer = $session->customer_details;

        // Optionally, update your subscription and payment records here
        // Example:
        $subscription = Subscription::where('provider_ref', $session->id)->with('plan')->first();
        if ($subscription) {
            $subscription->status = 'active';
            $subscription->save();

            Payment::where('provider_ref', $session->id)
                ->update(['status' => 'paid']);
        }

        $userId = Auth::id();

        $user = User::find($userId);

        $user->role = 'member';
        $user->save();

        $session = ChatbotSession::where('user_id', $userId)->first();

        $session->is_limited = false;
        $session->request_number = 3000;
        $session->save();

        // Render success page with customer data
        return Inertia::render('Web/SubscriptionPlan/Success', [
            'customer' => $customer,
            'plan' => $subscription->plan,
        ]);
    }


    public function cancel()
    {
        $userId = Auth::id();

        $subscription = Subscription::where('user_id', $userId)->latest()->first();
        if ($subscription) {
            $subscription->status = 'cancelled';
            $subscription->save();

            $payment = Payment::where('user_id', $userId)->latest()->first();


            if ($payment) {
                $payment->update(['status' => 'failed']);
            }
        }

        return Inertia::render('Web/SubscriptionPlan/Cancel');
    }
}
