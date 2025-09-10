<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlanRequest;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
