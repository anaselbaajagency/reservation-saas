<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// 🏠 Page d'accueil
Route::view('/', 'pages.home')->name('home');

// 👤 Dashboard Client
Route::view('/client/dashboard', 'client.dashboard')->name('client.dashboard');

// 👨‍💼 Dashboard Expert
Route::view('/expert/dashboard', 'expert.dashboard')->name('expert.dashboard');

// 🛠 Dashboard Admin
Route::view('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');

// 📋 Liste des experts
Route::view('/experts', 'pages.experts')->name('experts');

// 👤 Détail d'un expert
Route::view('/expert/show', 'pages.expert-show')->name('expert.show');

// 📅 Formulaire de réservation
Route::view('/reservation/form', 'pages.reservation-form')->name('reservation.form');

// 🌐 Welcome page (si tu veux la garder)
Route::view('/welcome', 'welcome')->name('welcome');

// Inscription
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Connexion
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Déconnexion
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Mot de passe oublié
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

// Reset password
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::middleware(['auth', 'role:admin,superadmin'])->group(function () {
    // Routes accessibles aux admins et superadmins
});


