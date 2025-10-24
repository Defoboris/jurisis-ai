<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotMessage;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
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
        ];

        return Inertia::render('SuperAdmin/Dashboard', [
            'stats' => $stats,
            'recentActivity' => $recentActivity
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
}
