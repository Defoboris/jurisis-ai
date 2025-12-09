<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotMessage;
use App\Models\ContactRequest;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use Inertia\Inertia;

class SuperAdminController extends Controller
{
    public function dashboard()
    {

        $stats = [
            'users' => User::whereIn('role', ['member', 'visitor'])->count(),
            'lawyers' => User::where('role', 'lawyer')->count(),
            'subscription' => Subscription::where('status', 'active')->count(),
            'totalAmount' => Payment::where('status', 'paid')->sum('amount_cents')

        ];

        $recentActivity = [
            'user_registered' => User::where('role', 'member')->latest()->first(),
            'subscription_upgraded' => Subscription::where('status', 'active')->with('user')->latest()->first(),
            'lawyer_joined' => User::where('role', 'lawyer')->latest()->first(),
            'chat_consultation' => ChatbotMessage::count(),
            'user_blocked' => User::where('role', 'member')->where('status', 'suspended')->count(),
            'contact_message' => ContactRequest::latest()->take(5)->get(),
        ];

        return Inertia::render('SuperAdmin/Dashboard', [
            'stats' => $stats,
            'recentActivity' => $recentActivity
        ]);
    }

    public function restApi()
    {
        $stats = [
            'users' => User::whereIn('role', ['member', 'visitor'])->count(),
            'lawyers' => User::where('role', 'lawyer')->count(),
            'subscription' => Subscription::where('status', 'active')->count(),
            'totalAmount' => Payment::where('status', 'paid')->sum('amount_cents')

        ];

        return response([
            'stats' => $stats
        ]);
    }

    public function userManagement()
    {

        return Inertia::render('SuperAdmin/UserManagement');
    }

    public function chatbotManagement()
    {
        return Inertia::render('SuperAdmin/ChatbotManagement');
    }

    public function lawyerManagement()
    {
        return Inertia::render('SuperAdmin/LawyerManagement');
    }

    public function subscriptionManagement()
    {
        return Inertia::render('SuperAdmin/SubscriptionManagement');
    }

    public function createUser(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], 201);
    }

    public function updateUser(Request $request, User $id)
    {
        // Validate request
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|lowercase|email|max:255|unique:users,email,' . $id->id,
            'password' => ['sometimes', 'nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        // Update name and email if provided
        if (isset($validated['name'])) {
            $id->name = $validated['name'];
        }

        if (isset($validated['email'])) {
            $id->email = $validated['email'];
        }

        // Update password only if provided and not empty
        if (!empty($validated['password'])) {
            $id->password = Hash::make($validated['password']);
        }

        // Save the changes
        $id->save();

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => $id
        ]);
    }
}
