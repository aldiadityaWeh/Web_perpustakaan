<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Pengaturan; // <-- Tambahkan model Pengaturan
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function peminjaman(Request $request)
    {
        $query = Peminjaman::with(['buku', 'anggota']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('tanggal_pinjam', [$start, $end]);
        }

        $peminjaman = $query->latest('tanggal_pinjam')->get();

        // Ambil data pengaturan
        $pengaturan = Pengaturan::first() ?? new Pengaturan();

        return view('admin.laporan.cetak-peminjaman', compact('peminjaman', 'request', 'pengaturan'));
    }

    public function buku()
    {
        $buku = Buku::orderBy('judul')->get();
        $pengaturan = Pengaturan::first() ?? new Pengaturan();

        return view('admin.laporan.cetak-buku', compact('buku', 'pengaturan'));
    }

    public function anggota()
    {
        $anggota = Anggota::orderBy('nama_lengkap')->get();
        $pengaturan = Pengaturan::first() ?? new Pengaturan();

        return view('admin.laporan.cetak-anggota', compact('anggota', 'pengaturan'));
    }
}
