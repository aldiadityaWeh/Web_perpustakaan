<?php

use Illuminate\Support\Facades\Route;

// Import semua Controller yang digunakan
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
| Semua rute di dalam grup ini hanya bisa diakses oleh pengunjung
| yang BELUM login. Jika sudah login, mereka akan dilempar ke Dashboard.
*/
Route::middleware('guest')->group(function () {

    // Halaman paling awal (Root) arahkan ke halaman Login
    Route::get('/', function () {
        return redirect()->route('login');
    });

    // Form dan Proses Login Manual
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    // Form dan Proses Pendaftaran
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');

    // Form Lupa Kata Sandi
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');

    // Login via Google (Socialite)
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

/*
|--------------------------------------------------------------------------
| RUTE LOGOUT
|--------------------------------------------------------------------------
*/
// Logout wajib diproteksi agar hanya orang yang sudah login yang bisa logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| AREA ADMIN (AUTH) - Wajib Login
|--------------------------------------------------------------------------
| Semua rute di dalam grup ini dikunci menggunakan middleware 'auth'.
| Pengunjung anonim tidak akan bisa masuk dan akan dilempar ke halaman Login.
*/
Route::middleware('auth')->group(function () {

    // --- Dashboard ---
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Alias jika sewaktu-waktu ada komponen yang memanggil nama route 'dashboard.index'
    Route::get('/admin/dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index');

    // --- Manajemen Data Master ---
    Route::resource('/admin/buku', BukuController::class);
    Route::resource('/admin/anggota', AnggotaController::class);

    // --- Transaksi Perpustakaan ---
    Route::resource('/admin/peminjaman', PeminjamanController::class);
    Route::resource('/admin/pengembalian', PengembalianController::class);
    Route::resource('/admin/transaksi', TransaksiController::class);

    // --- Analisis Perpustakaan ---
    Route::get('/admin/analisis', [AnalisisController::class, 'index'])->name('analisis.index');

    // --- Laporan & Rekap Data ---
    Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/admin/laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
    Route::get('/admin/laporan/buku', [LaporanController::class, 'buku'])->name('laporan.buku');
    Route::get('/admin/laporan/anggota', [LaporanController::class, 'anggota'])->name('laporan.anggota');

    // --- Pengaturan Sistem (Penyimpanan via JSON) ---
    Route::get('/admin/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/admin/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');

    // --- Profil Administrator ---
    Route::get('/admin/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/admin/profil/info', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/admin/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');

});
