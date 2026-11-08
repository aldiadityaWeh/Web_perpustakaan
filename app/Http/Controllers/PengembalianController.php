<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku'])->where('status', 'Dikembalikan');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('anggota', function ($subQ) use ($search) {
                    $subQ->where('nama_lengkap', 'like', '%' . $search . '%')
                         ->orWhere('nis', 'like', '%' . $search . '%');
                })->orWhereHas('buku', function ($subQ) use ($search) {
                    $subQ->where('judul', 'like', '%' . $search . '%')
                         ->orWhere('isbn', 'like', '%' . $search . '%');
                });
            });
        }

        // Mengurutkan berdasarkan kolom tanggal_kembali[cite: 2]
        $pengembalians = $query->latest('tanggal_kembali')
                               ->latest('updated_at')
                               ->paginate(6)
                               ->withQueryString();

        return view('admin.pengembalian.index', compact('pengembalians'));
    }
}
