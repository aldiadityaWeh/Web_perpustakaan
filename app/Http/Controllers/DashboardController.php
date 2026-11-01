<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today();

        // 1. Menghitung Total Buku (Bisa diganti sum('stok') jika menghitung eksemplar)
        $totalBuku = Buku::count();

        // 2. Menghitung Total Anggota Aktif
        $anggotaAktif = Anggota::count();

        // 3. Menghitung Buku yang Sedang Dipinjam (Status belum kembali)
        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();

        // 4. Menghitung Transaksi Jatuh Tempo / Terlambat
        $jatuhTempo = Peminjaman::where('status', 'dipinjam')
                                ->whereDate('tanggal_jatuh_tempo', '<=', $hariIni)
                                ->count();

        // 5. Mengambil 5 Data Transaksi Teratas untuk Tabel "Perlu Perhatian"
        // Menggunakan with() untuk meminimalisir N+1 Query Problem pada relasi anggota & buku
        $perluPerhatian = Peminjaman::with(['anggota', 'buku'])
                                    ->where('status', 'dipinjam')
                                    ->whereDate('tanggal_jatuh_tempo', '<=', $hariIni)
                                    ->orderBy('tanggal_jatuh_tempo', 'asc') // Urutkan dari yang paling telat
                                    ->take(5)
                                    ->get();

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
