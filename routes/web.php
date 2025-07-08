<?php

use Illuminate\Support\Facades\Route;

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
