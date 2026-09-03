<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// --- Autentikasi ---

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', function() {
    return redirect()->route('dashboard');
})->name('login.process');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', function() {
    return "Proses Register";
})->name('register.process');

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');


// --- Dashboard ---

Route::get('/dashboard', function () {
    return view('admin.dashboard.index');
})->name('dashboard.index');


// --- Manajemen Buku ---

Route::resource('/admin/buku', App\Http\Controllers\BukuController::class);


// --- Manajemen Anggota ---

Route::resource('/admin/anggota', App\Http\Controllers\AnggotaController::class);


// --- Peminjaman ---

Route::resource('/admin/peminjaman', App\Http\Controllers\PeminjamanController::class);




// --- Pengembalian ---

Route::resource('/admin/pengembalian', App\Http\Controllers\PengembalianController::class);


// --- Riwayat Transaksi ---
Route::resource('/admin/transaksi', App\Http\Controllers\TransaksiController::class);



// --- Laporan ---

Route::get('/admin/laporan', function () {
    return view('admin.laporan.index');
})->name('laporan.index');

// --- Analisis ---
Route::get('/admin/analisis', function () {
    return view('admin.analisis.index');
})->name('analisis.index');

// --- Pengaturan ---

Route::get('/admin/pengaturan', function () {
    return view('admin.pengaturan.index');
})->name('pengaturan.index');


// --- Profil ---

Route::get('/admin/profil', function () {
    return view('admin.profil.index');
})->name('profil.index');
