<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Website\LawyerController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'lawyer'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

});

Route::middleware(['auth', 'admin'])->prefix('super-admin')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('super-admin.dashboard');
    Route::get('/user-management', [UserController::class, 'index'])->name('super-admin.user-management');
    Route::get('/chatbot-management', [SuperAdminController::class, 'chatbotManagement'])->name('super-admin.chatbot-management');

    Route::get('/lawyer-management', [LawyerController::class, 'lawyerManagement'])->name('super-admin.lawyerManagement');
    Route::post('/lawyer-management', [LawyerController::class, 'create'])->name('super-admin.lawyerManagement.create');
    Route::put('/lawyer-management/{lawyer}', [LawyerController::class, 'update'])->name('super-admin.lawyerManagement.update');
    Route::put('/lawyer-management/{lawyer}/moderate/{state}', [LawyerController::class, 'moderate'])->name('super-admin.lawyers.moderate');

    Route::get('/subscription-management', [PlanController::class, 'index'])->name('super-admin.subscriptionManagement');
});
