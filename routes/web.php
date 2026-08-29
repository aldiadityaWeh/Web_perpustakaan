<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Routes untuk Autentikasi (Guest)
|--------------------------------------------------------------------------
| Berisi rute untuk halaman login, register, dan lupa password.
*/

// Redirect root ke login
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


/*
|--------------------------------------------------------------------------
| Routes untuk Halaman Utama (Admin/User yang sudah Login)
|--------------------------------------------------------------------------
*/

// Dashboard Route mengarah ke struktur folder baru: admin/dashboard/index
Route::get('/dashboard', function () {
    return view('admin.dashboard.index');
})->name('dashboard');


/*
|--------------------------------------------------------------------------
| Routes untuk Manajemen Buku
|--------------------------------------------------------------------------
| Berisi rute untuk menampilkan daftar buku, form tambah, dan proses data buku.
*/

Route::get('/admin/buku', function () {
    return view('admin.buku.index');
})->name('buku.index');

Route::get('/admin/buku/create', function () {
    return view('admin.buku.create');
})->name('buku.create');


/*
|--------------------------------------------------------------------------
| Routes untuk Manajemen Anggota
|--------------------------------------------------------------------------
| Berisi rute untuk menampilkan daftar anggota dan form pendaftaran anggota baru.
*/

Route::get('/admin/anggota', function () {
    return view('admin.anggota.index');
})->name('anggota.index');

Route::get('/admin/anggota/create', function () {
    // Rute form tambah anggota (akan dibuat nanti)
    return view('admin.anggota.create');
})->name('anggota.create');

/*
|--------------------------------------------------------------------------
| Routes untuk Manajemen Peminjaman
|--------------------------------------------------------------------------
| Berisi rute untuk menampilkan data transaksi peminjaman dan formnya.
*/

Route::get('/admin/peminjaman', function () {
    return view('admin.peminjaman.index');
})->name('peminjaman.index');

Route::get('/admin/peminjaman/create', function () {
    return view('admin.peminjaman.create');
})->name('peminjaman.create');

/*
    |--------------------------------------------------------------------------
    | Routes untuk Manajemen Pengembalian
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/pengembalian', function () {
        return view('admin.pengembalian.index');
    })->name('pengembalian.index');

    /*
    |--------------------------------------------------------------------------
    | Routes untuk Riwayat Transaksi
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/transaksi', function () {
        return view('admin.transaksi.index');
    })->name('transaksi.index');


    // laporan
    Route::get('/admin/laporan', function () {
    return view('admin.laporan.index');
    })->name('laporan.index');

    // pengaturan
    Route::get('/admin/pengaturan', function () {
    return view('admin.pengaturan.index');
})->name('pengaturan.index');

// profil
Route::get('/admin/profil', function () {
    return view('admin.profil.index');
})->name('profil.index');
