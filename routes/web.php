<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\ProfilController;

/*
|--------------------------------------------------------------------------
| AREA TAMU (GUEST) - Belum Login
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/', function () {
        return redirect()->route('login');
    });

    // Form dan Proses Login Manual
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    // Form dan Proses Pendaftaran
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');

    // Lupa & Reset Kata Sandi
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email'); // Proses kirim link
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset'); // Halaman buat sandi baru
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update'); // Proses simpan sandi baru
});

/*
|--------------------------------------------------------------------------
| RUTE LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| AREA ADMIN (AUTH) - Wajib Login
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // --- Dashboard ---
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index');

    // --- Manajemen Data Master ---
    Route::resource('/admin/buku', BukuController::class);
    Route::resource('/admin/anggota', AnggotaController::class);

    // --- Transaksi Perpustakaan (Sirkulasi & Kas) ---
    // 1. Rute Khusus Validasi (Harus di atas resource agar tidak bentrok)
    Route::get('/admin/peminjaman/{id}/validasi', [PeminjamanController::class, 'formValidasi'])->name('peminjaman.validasi');
    Route::post('/admin/peminjaman/{id}/validasi', [PeminjamanController::class, 'prosesValidasi'])->name('peminjaman.prosesValidasi');

    // 2. Resource Utama
    Route::resource('/admin/peminjaman', PeminjamanController::class);
    Route::resource('/admin/pengembalian', PengembalianController::class); // Untuk Riwayat
    Route::resource('/admin/transaksi', TransaksiController::class); // Untuk Kas Denda

    // --- Analisis Perpustakaan ---
    Route::get('/admin/analisis', [AnalisisController::class, 'index'])->name('analisis.index');

    // --- Laporan & Rekap Data ---
    Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/admin/laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
    Route::get('/admin/laporan/buku', [LaporanController::class, 'buku'])->name('laporan.buku');
    Route::get('/admin/laporan/anggota', [LaporanController::class, 'anggota'])->name('laporan.anggota');

    // --- Pengaturan Sistem ---
    Route::get('/admin/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/admin/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');

    // --- Profil  ---
    Route::get('/admin/profil', [App\Http\Controllers\ProfilController::class, 'index'])->name('profil.index');
    Route::put('/admin/profil', [App\Http\Controllers\ProfilController::class, 'update'])->name('profil.update');

});
