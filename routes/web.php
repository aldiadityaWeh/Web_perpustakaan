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

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard.index');
})->name('dashboard.index');


// --- Manajemen Buku ---

Route::get('/admin/buku', function () {
    return view('admin.buku.index');
})->name('buku.index');

Route::get('/admin/buku/create', function () {
    return view('admin.buku.create');
})->name('buku.create');


// --- Manajemen Anggota ---

Route::get('/admin/anggota', function () {
    return view('admin.anggota.index');
})->name('anggota.index');

Route::get('/admin/anggota/create', function () {
    return view('admin.anggota.create');
})->name('anggota.create');


// --- Peminjaman ---

Route::get('/admin/peminjaman', function () {
    return view('admin.peminjaman.index');
})->name('peminjaman.index');

Route::get('/admin/peminjaman/create', function () {
    return view('admin.peminjaman.create');
})->name('peminjaman.create');


// --- Pengembalian ---

Route::get('/admin/pengembalian', function () {
    return view('admin.pengembalian.index');
})->name('pengembalian.index');


// --- Riwayat Transaksi ---

Route::get('/admin/transaksi', function () {
    return view('admin.transaksi.index');
})->name('transaksi.index');


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
