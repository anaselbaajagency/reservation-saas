<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AuthController;
use App\Models\User;

// =====================
// Routes publiques
// =====================
Route::middleware('guest')->group(function () {
    // Pages publiques
    Route::view('/', 'pages.home')->name('home');
    Route::view('/experts', 'pages.experts')->name('experts');
    Route::view('/expert/show', 'pages.expert-show')->name('expert.show');
    Route::view('/reservation/form', 'pages.reservation-form')->name('reservation.form');
    Route::view('/terms', 'terms')->name('terms');
    Route::view('/privacy', 'policy')->name('policy');

    // Auth: inscription / connexion
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Réinitialisation de mot de passe
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// =====================
// Routes avec authentification
// =====================
Route::middleware('auth')->group(function () {
    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Vérification d'email
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
// Routes protégées : auth + email vérifié
// =====================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Dashboards spécifiques (admin / expert / client)
    Route::view('/client/dashboard', 'client.dashboard')->name('client.dashboard');
    Route::view('/expert/dashboard', 'expert.dashboard')->name('expert.dashboard');
    Route::view('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');

    // Ajoute ici les routes protégées supplémentaires
});

// =====================
// Vérification AJAX de l'email
// =====================
Route::get('/check-email', function (Request $request) {
    return response()->json([
        'exists' => User::where('email', $request->email)->exists()
    ]);
});
