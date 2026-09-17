<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // Menampilkan halaman menu laporan utama
    public function index()
    {
        return view('admin.laporan.index');
    }

    // Mencetak Laporan Peminjaman (Mendukung Filter Tanggal)
    public function peminjaman(Request $request)
    {
        $query = Peminjaman::with(['buku', 'anggota']);

        // Jika ada filter tanggal yang dikirim
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('tanggal_pinjam', [$start, $end]);
        }

        $peminjaman = $query->latest('tanggal_pinjam')->get();
        return view('admin.laporan.cetak-peminjaman', compact('peminjaman', 'request'));
    }

    // Mencetak Laporan Data Buku
    public function buku()
    {
        $buku = Buku::orderBy('judul')->get();
        return view('admin.laporan.cetak-buku', compact('buku'));
    }

    // Mencetak Laporan Data Anggota
    public function anggota()
    {
        $anggota = Anggota::orderBy('nama_lengkap')->get();
        return view('admin.laporan.cetak-anggota', compact('anggota'));
    }
}
