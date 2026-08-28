<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', function() {
    return redirect()->route('dashboard');
})->name('login.process');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', function() {
    return "Proses Register";
})->name('register.process');

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');

// Dashboard Route mengarah ke struktur folder baru: admin/dashboard/index
Route::get('/dashboard', function () {
    return view('admin.dashboard.index');
})->name('dashboard');
