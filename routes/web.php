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

// --- Analisis Perpustakaan ---
Route::get('/admin/analisis', [App\Http\Controllers\AnalisisController::class, 'index'])->name('analisis.index');

// --- Laporan ---
Route::get('/admin/laporan', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
Route::get('/admin/laporan/peminjaman', [App\Http\Controllers\LaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
Route::get('/admin/laporan/buku', [App\Http\Controllers\LaporanController::class, 'buku'])->name('laporan.buku');
Route::get('/admin/laporan/anggota', [App\Http\Controllers\LaporanController::class, 'anggota'])->name('laporan.anggota');


// --- Pengaturan ---

Route::get('/admin/pengaturan', function () {
    return view('admin.pengaturan.index');
})->name('pengaturan.index');


// --- Profil ---

Route::get('/admin/profil', function () {
    return view('admin.profil.index');
})->name('profil.index');
