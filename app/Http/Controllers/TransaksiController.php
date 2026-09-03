<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Menampilkan semua riwayat transaksi (Buku Induk Log)
     */
    public function index(Request $request)
    {
        // Memanggil model Peminjaman dengan relasi buku dan anggota
        $query = Peminjaman::with(['buku', 'anggota']);

        // Logika Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Cari berdasarkan ID Transaksi (Hanya angka)
                $q->where('id', 'like', '%' . str_replace('TRX-', '', $search) . '%')
                // Atau Nama Siswa
                ->orWhereHas('anggota', function($subQ) use ($search) {
                    $subQ->where('nama_lengkap', 'like', '%' . $search . '%');
                })
                // Atau Judul Buku
                ->orWhereHas('buku', function($subQ) use ($search) {
                    $subQ->where('judul', 'like', '%' . $search . '%');
                });
            });
        }

        // Ambil semua transaksi tanpa filter status, urutkan dari yang terbaru
        $transaksis = $query->latest()->paginate(10)->withQueryString();

        return view('admin.transaksi.index', compact('transaksis'));
    }

    /**
     * Menampilkan detail spesifik satu transaksi (seperti struk/bon)
     */
    public function show(string $id)
    {
        // Ambil data transaksi beserta data relasi buku dan anggotanya
        $transaksi = Peminjaman::with(['buku', 'anggota'])->findOrFail($id);

        // Arahkan ke file resources/views/admin/transaksi/show.blade.php
        return view('admin.transaksi.show', compact('transaksi'));
    }

    /**
     * Hapus permanen riwayat (Opsional)
     */
    public function destroy(string $id)
    {
        $transaksi = Peminjaman::findOrFail($id);

        // Jika yang dihapus ternyata masih berstatus 'dipinjam', otomatis kembalikan stok buku
        if ($transaksi->status == 'dipinjam') {
            if ($transaksi->buku) {
                $transaksi->buku->increment('stok', 1);
            }
        }

        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Riwayat transaksi berhasil dihapus permanen!');
    }
}
