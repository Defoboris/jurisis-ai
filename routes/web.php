<?php

use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Member\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Website\AboutController;
use App\Http\Controllers\Website\ArticleController;
use App\Http\Controllers\Website\ChatController;
use App\Http\Controllers\Website\ConversationController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\LawyerController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lawyers', [LawyerController::class, 'index'])->name('lawyers');
Route::get('/lawyers/details/{lawyer}', [LawyerController::class, 'show'])->name('lawyer.show');

Route::get('/articles', [ArticleController::class, 'index'])->name('articles');

Route::get('/chat', [ChatController::class, 'index'])->name('chat');
Route::get('/chat/stream', [ChatController::class, 'stream'])->name('chat.stream');
 
Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations');

Route::middleware(['auth'])->group(function () {
    Route::post('/conversations/start/{lawyer}', [ConversationController::class, 'store'])->name('conversations.store');

    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');
    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store'])->name('messages.store');
});

Route::get('/subscriptions-plans', [SubscriptionController::class, 'index'])->name('subscriptions-plans');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';

// Member-only routes
// Route::middleware(['auth','member'])->group(function () {
//     Route::resource('appointments', Member\AppointmentController::class);
//     Route::post('chatbot/message', [Member\ChatbotController::class, 'store']);
// });

// // Lawyer-only routes
// Route::middleware(['auth','lawyer'])->group(function () {
//     Route::resource('lawyer/appointments', Lawyer\AppointmentController::class);
//     Route::put('lawyer/page', [Lawyer\LawyerPageController::class, 'update']);
// });

// // Admin-only routes
// Route::middleware(['auth','admin'])->group(function () {
//     Route::resource('admin/users', Admin\UserController::class);
//     Route::resource('admin/lawyers', Admin\LawyerController::class);
//     Route::resource('admin/plans', Admin\PlanController::class);
// });

// Members can only access chatbot, appointments, subscriptions.

// Lawyers can only manage their lawyer page & client appointments.

// Admins can manage everything.