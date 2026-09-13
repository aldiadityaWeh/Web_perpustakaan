<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    // Menampilkan halaman tabel Riwayat Pengembalian
    public function index(Request $request)
    {
        // Hanya ambil data yang statusnya 'Dikembalikan'
        $query = Peminjaman::with(['anggota', 'buku'])->where('status', 'Dikembalikan');

        // Logika Live Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('anggota', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%');
            })->orWhereHas('buku', function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%');
            });
        }

        // Urutkan berdasarkan waktu pengembalian (updated_at) terbaru
        $pengembalians = $query->latest('updated_at')->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('admin.pengembalian.index', compact('pengembalians'));
        }

        return view('admin.pengembalian.index', compact('pengembalians'));
    }

    // Fungsi Utama: Eksekusi Tombol Verifikasi "Belum Kembali"
    public function store(string $id)
    {
        // Cari data transaksi peminjaman berdasarkan ID
        $pinjam = Peminjaman::with('buku')->findOrFail($id);

        // Keamanan: Jika sudah dikembalikan sebelumnya, batalkan
        if ($pinjam->status == 'Dikembalikan') {
            return back()->with('error', 'Buku ini sudah diproses pengembaliannya sebelumnya.');
        }

        try {
            // Gunakan Database Transaction agar aman
            DB::transaction(function () use ($pinjam) {

                // 1. Ubah status transaksi menjadi 'Dikembalikan'
                $pinjam->update([
                    'status' => 'Dikembalikan',
                    // Note: 'updated_at' akan otomatis tercatat sebagai waktu (jam/hari) pengembalian
                ]);

                // 2. Kembalikan (tambah) stok buku +1
                if ($pinjam->buku) {
                    $pinjam->buku->increment('stok');
                }
            });

            // Berhasil! Kembali ke halaman peminjaman dengan pesan sukses
            return back()->with('success', 'Buku "' . ($pinjam->buku->judul ?? 'Tidak diketahui') . '" berhasil diverifikasi. Stok buku telah bertambah!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem saat memproses pengembalian: ' . $e->getMessage());
        }
    }
}
