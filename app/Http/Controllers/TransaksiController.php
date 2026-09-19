<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Menampilkan riwayat pemasukan Kas Denda (Hanya yang memiliki denda)
     */
   public function index(Request $request)
    {
        // 1. Ambil data HANYA yang sudah dikembalikan dan MEMILIKI DENDA (> 0)
        $query = Peminjaman::with(['buku', 'anggota'])
                    ->where('status', 'Dikembalikan')
                    ->where('denda', '>', 0);

        // 2. Hitung total uang kas denda keseluruhan
        $totalKas = Peminjaman::where('status', 'Dikembalikan')->sum('denda');

        // 3. Logika Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Cari berdasarkan ID Transaksi (Hanya angka)
                $q->where('id', 'like', '%' . str_replace('TRX-', '', $search) . '%')
                // Atau Nama Siswa & NIS (DIPERBAIKI: Tambahkan pencarian NIS)
                ->orWhereHas('anggota', function($subQ) use ($search) {
                    $subQ->where('nama_lengkap', 'like', '%' . $search . '%')
                         ->orWhere('nis', 'like', '%' . $search . '%');
                })
                // Atau Judul Buku
                ->orWhereHas('buku', function($subQ) use ($search) {
                    $subQ->where('judul', 'like', '%' . $search . '%');
                });
            });
        }

        // 4. Urutkan dari transaksi denda terbaru
        $transaksis = $query->latest('updated_at')->paginate(10)->withQueryString();

        return view('admin.transaksi.index', compact('transaksis', 'totalKas'));
    }

    /**
     * Menampilkan detail spesifik satu transaksi (seperti struk/bon)
     */
    public function show(string $id)
    {
        // Ambil data transaksi beserta data relasi buku dan anggotanya
        $transaksi = Peminjaman::with(['buku', 'anggota'])->findOrFail($id);

        // Arahkan ke file resources/views/admin/transaksi/show.blade.php (Jika Anda membuatnya)
        return view('admin.transaksi.show', compact('transaksi'));
    }

    /**
     * Hapus permanen riwayat Kas/Transaksi
     */
    public function destroy(string $id)
    {
        $transaksi = Peminjaman::findOrFail($id);

        // Keamanan tambahan: Jika yang dihapus ternyata masih berstatus 'dipinjam', otomatis kembalikan stok buku
        if (strtolower(trim($transaksi->status)) == 'dipinjam') {
            if ($transaksi->buku) {
                $transaksi->buku->increment('stok', 1);
            }
        }

        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Riwayat kas denda berhasil dihapus permanen!');
    }
}
