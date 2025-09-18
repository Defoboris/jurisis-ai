<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $subscriptionPlans = SubscriptionPlan::all();
        return Inertia::render('SuperAdmin/SubscriptionPlan', [
            'subscriptionPlans' => $subscriptionPlans
        ]);
    }

    public function update(Request $request)
    {
        // dd($request->all()); // optional, for debugging

        // Validate request
        $data = $request->validate([
            'plans' => 'required|array|min:1',
            'plans.*.id' => 'required|exists:subscription_plans,id',
            'plans.*.name' => 'required|string|max:255',
            'plans.*.price_cents' => 'required|numeric|min:0',
            'plans.*.description' => 'nullable|string',
            'plans.*.featuresString' => 'nullable|string', // <-- validate the string from frontend
        ]);

        foreach ($data['plans'] as $planData) {
            $plan = SubscriptionPlan::find($planData['id']);

            // Convert featuresString to array
            $featuresArray = isset($planData['featuresString'])
                ? array_filter(array_map('trim', explode(',', $planData['featuresString'])))
                : [];

            $plan->update([
                'name' => $planData['name'],
                'price_cents' => $planData['price_cents'],
                'description' => $planData['description'] ?? null,
                'features' => $featuresArray, // stored as JSON in DB
            ]);
        }

        return back()->with('success', 'Subscription plans updated successfully');
    }
}
