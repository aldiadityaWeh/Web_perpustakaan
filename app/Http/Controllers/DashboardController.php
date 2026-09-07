<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil waktu hari ini untuk patokan
        $hariIni = Carbon::now()->startOfDay();

        // 2. Hitung Total Stok Buku (Menjumlahkan angka di kolom 'stok')
        $totalBuku = Buku::sum('stok');

        // 3. Hitung Anggota Aktif
        $anggotaAktif = Anggota::where('status', 'Aktif')->count();

        // 4. Hitung Buku yang Sedang Dipinjam
        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();

        // 5. Hitung Transaksi Jatuh Tempo (Status terlambat, atau status dipinjam tapi tanggalnya sudah lewat)
        $jatuhTempo = Peminjaman::where('status', 'terlambat')
            ->orWhere(function($query) use ($hariIni) {
                $query->where('status', 'dipinjam')
                      ->whereDate('tanggal_jatuh_tempo', '<', $hariIni);
            })->count();

        // 6. Ambil Data "Perlu Perhatian" (Buku yang harus dikembalikan hari ini atau sudah lewat)
        $perluPerhatian = Peminjaman::with(['buku', 'anggota'])
            ->where('status', 'dipinjam')
            ->whereDate('tanggal_jatuh_tempo', '<=', $hariIni)
            ->orderBy('tanggal_jatuh_tempo', 'asc') // Urutkan dari yang paling terlambat
            ->take(5) // Ambil 5 teratas agar tabel tidak terlalu panjang
            ->get();

        // 7. Kirim semua data yang sudah dihitung ke halaman View (Blade)
        return view('admin.dashboard.index', compact(
            'totalBuku',
            'anggotaAktif',
            'sedangDipinjam',
            'jatuhTempo',
            'perluPerhatian',
            'hariIni'
        ));
    }
}
