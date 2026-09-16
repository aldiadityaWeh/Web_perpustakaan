<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    // =====================================================================
    // 1. FUNGSI INDEX: Menampilkan halaman tabel Riwayat Pengembalian
    // =====================================================================
    public function index(Request $request)
    {
        // Menarik data peminjaman beserta relasi (anggota & buku)
        // HANYA yang statusnya sudah 'Dikembalikan'
        $query = Peminjaman::with(['anggota', 'buku'])->where('status', 'Dikembalikan');

        // Logika untuk fitur pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('anggota', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%');
            })->orWhereHas('buku', function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%');
            });
        }

        // Mengurutkan dari tanggal dikembalikan yang paling baru (updated_at)
        $pengembalians = $query->latest('updated_at')->paginate(6)->withQueryString();

        // Jika request dari JavaScript (Live Search AJAX), kembalikan hanya bagian view-nya saja
        if ($request->ajax()) {
            return view('admin.pengembalian.index', compact('pengembalians'));
        }

        // Tampilan normal halaman penuh
        return view('admin.pengembalian.index', compact('pengembalians'));
    }
}
