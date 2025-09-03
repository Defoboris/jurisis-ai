<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SuperAdminController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/super-admin', [SuperAdminController::class, 'dashboard'])->name('super-admin.dashboard');

});