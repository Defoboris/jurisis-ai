<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SuperAdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'lawyer'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'admin'])->prefix('super-admin')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('super-admin.dashboard');
    Route::get('/user-management', [SuperAdminController::class, 'userManagement'])->name('super-admin.user-management');
    Route::get('/chatbot-management', [SuperAdminController::class, 'chatbotManagement'])->name('super-admin.chatbot-management');
    Route::get('/lawyer-management', [SuperAdminController::class, 'lawyerManagement'])->name('super-admin.lawyerManagement');
    Route::get('/subscription-management', [SuperAdminController::class, 'subscriptionManagement'])->name('super-admin.subscriptionManagement');
});
