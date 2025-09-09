<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('SuperAdmin/Dashboard');
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
