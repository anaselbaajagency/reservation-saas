<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\RoleController;
use App\Models\User;
use App\Http\Controllers\Superadmin\DashboardController as SuperadminDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;

// =====================
// PUBLIC ROUTES (Guest only)
// =====================
Route::middleware('guest')->group(function () {
    // Public pages
    Route::view('/', 'pages.home')->name('home');
    Route::view('/welcome', 'welcome')->name('welcome');
    Route::view('/experts', 'pages.experts')->name('experts');
    Route::view('/expert/show', 'pages.expert-show')->name('expert.show');
    Route::view('/reservation/form', 'pages.reservation-form')->name('reservation.form');
    Route::view('/terms', 'terms')->name('terms');
    Route::view('/privacy', 'policy')->name('policy');

    // Authentication routes
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']); // This will redirect to /dashboard after successful login

    // Password reset routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// =====================
// AUTHENTICATED ROUTES (No email verification required)
// =====================
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Email verification routes
    Route::get('/email/verify', function () {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect()->intended('/dashboard');
        }
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        $request->user()->update([
            'email_verified_at' => now(),
            'status' => 'active'
        ]);
        return redirect()->intended('/dashboard');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');
});

// =====================
// VERIFIED USER ROUTES (Auth + Email verified)
// =====================
Route::middleware(['auth', 'verified'])->group(function () {
    // Main dashboard (static - gets data from session)
    Route::get('/dashboard', function () {
        // Get data from session (set by role controllers)
        $data = session()->get('dashboard_data', []);
        return view('dashboard', $data);
    })->name('dashboard');
});

// =====================
// ROLE-BASED DASHBOARD ROUTES
// =====================

// Super Admin Routes
Route::middleware(['auth', 'verified', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {
        Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])->name('dashboard');
        
        // Role management
        Route::resource('roles', RoleController::class)
            ->except(['show'])
            ->names([
                'index'   => 'roles.index',
                'create'  => 'roles.create',
                'store'   => 'roles.store',
                'edit'    => 'roles.edit',
                'update'  => 'roles.update',
                'destroy' => 'roles.destroy',
            ]);
        
        // Reservation management
        Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
        Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    });

// Admin Routes
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Role management for admins
        Route::resource('roles', RoleController::class)->except(['show']);
    });

// Expert Routes
Route::middleware(['auth', 'verified', 'role:expert'])
    ->prefix('expert')
    ->name('expert.')
    ->group(function () {
        Route::get('/dashboard', function() {
            return view('expert.dashboard');
        })->name('dashboard');
    });

// Client Routes
Route::middleware(['auth', 'verified', 'role:client'])
    ->prefix('client')
    ->name('client.')
    ->group(function () {
        Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
        Route::get('/expert/{expert}', [ClientDashboardController::class, 'showExpert'])->name('expert.show');
    });

// =====================
// PERMISSION-BASED ROUTES
// =====================

// Reservation permissions
Route::middleware(['auth', 'verified', 'permission:view reservations'])->group(function() {
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
});

Route::middleware(['auth', 'verified', 'permission:create reservations'])->group(function() {
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
});

// =====================
// UTILITY ROUTES
// =====================

// AJAX email check (public)
Route::get('/check-email', function (Request $request) {
    return response()->json([
        'exists' => User::where('email', $request->email)->exists()
    ]);
});