<?php

use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KioskController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AREA TAMU (GUEST) - Belum Login
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| RUTE UMUM (ADMIN & PETUGAS)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // --- Dashboard & Profil ---
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/admin/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/admin/profil', [ProfilController::class, 'update'])->name('profil.update');

    // --- Akses Baca (Read-Only) Buku & Anggota ---
    Route::get('/admin/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/admin/buku/{buku}', [BukuController::class, 'show'])->name('buku.show');

    Route::get('/admin/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('/admin/anggota/{anggota}', [AnggotaController::class, 'show'])->name('anggota.show');

    // --- Mencetak Label Buku & Kartu Anggota ---
    Route::get('/admin/cetak-massal-anggota', [AnggotaController::class, 'cetakMassal'])->name('anggota.cetakMassal');
    Route::get('/admin/cetak-massal-label', [BukuController::class, 'cetakMassal'])->name('buku.cetakMassal');
    Route::get('/admin/anggota/{id}/cetak-kartu', [AnggotaController::class, 'cetakKartu'])->name('anggota.cetak_kartu');
    Route::get('/admin/buku/{id}/cetak-label', [BukuController::class, 'cetakLabel'])->name('buku.cetak_label');

    // --- Transaksi Perpustakaan (Sirkulasi & Kas) ---
    Route::get('/admin/peminjaman/{id}/validasi', [PeminjamanController::class, 'formValidasi'])->name('peminjaman.validasi');
    Route::post('/admin/peminjaman/{id}/validasi', [PeminjamanController::class, 'prosesValidasi'])->name('peminjaman.prosesValidasi');
    Route::get('/admin/denda', [PeminjamanController::class, 'daftarDenda'])->name('denda.index');
    Route::post('/admin/denda/{id}/lunas', [PeminjamanController::class, 'lunasiDenda'])->name('denda.lunas');
    Route::post('/admin/peminjaman/{id}/terima-ganti', [PeminjamanController::class, 'terimaBukuGanti'])->name('peminjaman.terimaGanti');

    Route::resource('/admin/peminjaman', PeminjamanController::class);
    Route::resource('/admin/pengembalian', PengembalianController::class);
    Route::resource('/admin/transaksi', TransaksiController::class);

    // --- Analisis & Laporan ---
    Route::get('/admin/analisis', [AnalisisController::class, 'index'])->name('analisis.index');
    Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/admin/laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
    Route::get('/admin/laporan/buku', [LaporanController::class, 'buku'])->name('laporan.buku');
    Route::get('/admin/laporan/anggota', [LaporanController::class, 'anggota'])->name('laporan.anggota');

    // --- Kiosk Peminjaman ---
    Route::get('/admin/kiosk-peminjaman', [KioskController::class, 'index'])->name('kiosk.index');
    Route::post('/admin/kiosk-peminjaman/auth', [KioskController::class, 'authenticate'])->name('kiosk.auth');
    Route::get('/admin/kiosk-peminjaman/katalog', [KioskController::class, 'katalog'])->name('kiosk.katalog');
    Route::post('/admin/kiosk-peminjaman/store', [KioskController::class, 'store'])->name('kiosk.store');
});

/*
|--------------------------------------------------------------------------
| RUTE KHUSUS ADMIN (HAK AKSES PENUH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    // --- Akses Tulis (Create, Edit, Update, Destroy) Buku ---
    // PERHATIKAN: Route 'create' diletakkan secara eksplisit
    Route::get('/admin/buku/create/baru', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/admin/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/admin/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/admin/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/admin/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');

    // --- Akses Tulis (Create, Edit, Update, Destroy) Anggota ---
    // PERHATIKAN: Route 'create' diletakkan secara eksplisit
    Route::get('/admin/anggota/create/baru', [AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('/admin/anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/admin/anggota/{anggota}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('/admin/anggota/{anggota}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/admin/anggota/{anggota}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');

    // --- Pengaturan Sistem & Manajemen Petugas ---
    Route::get('/admin/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/admin/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    Route::post('/admin/pengaturan/petugas', [PengaturanController::class, 'storePetugas'])->name('pengaturan.petugas.store');
    Route::put('/admin/pengaturan/petugas/{id}', [PengaturanController::class, 'updatePetugas'])->name('pengaturan.petugas.update');
    Route::delete('/admin/pengaturan/petugas/{id}', [PengaturanController::class, 'destroyPetugas'])->name('pengaturan.petugas.destroy');
});
