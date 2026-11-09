<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Menampilkan riwayat pemasukan Kas Denda (Hanya yang LUNAS)
     */
    public function index(Request $request)
    {
        // 1. Ambil data HANYA yang sudah dikembalikan, memiliki denda, DAN SUDAH LUNAS.
        $query = Peminjaman::with(['buku', 'anggota'])
                    ->where('status', 'Dikembalikan')
                    ->where('denda', '>', 0)
                    ->where('status_denda', 'Lunas');

        // 2. Hitung total uang kas denda HANYA dari denda yang sudah diserahkan (Lunas)
        $totalKas = (clone $query)->sum('denda');

        // 3. Logika Pencarian
        if ($request->filled('search')) {
            $search = trim($request->search);
            // Bersihkan awalan TRX- (case-insensitive) dan angka nol di depan (misal TRX-0005 -> 5)
            $cleanId = ltrim(str_ireplace('trx-', '', $search), '0');

            $query->where(function ($q) use ($search, $cleanId) {
                if ($cleanId !== '' && is_numeric($cleanId)) {
                    $q->where('id', $cleanId)
                      ->orWhere('id', 'like', '%' . $cleanId . '%');
                }

                // Atau Nama Siswa & NIS
                $q->orWhereHas('anggota', function ($subQ) use ($search) {
                    $subQ->where('nama_lengkap', 'like', '%' . $search . '%')
                         ->orWhere('nis', 'like', '%' . $search . '%');
                })
                // Atau Judul Buku & ISBN
                ->orWhereHas('buku', function ($subQ) use ($search) {
                    $subQ->where('judul', 'like', '%' . $search . '%')
                         ->orWhere('isbn', 'like', '%' . $search . '%');
                });
            });
        }

        // 4. Urutkan dari transaksi denda terbaru yang baru dilunasi
        $transaksis = $query->latest('updated_at')->paginate(10)->withQueryString();

        return view('admin.transaksi.index', compact('transaksis', 'totalKas'));
    }

    /**
     * Menampilkan detail spesifik satu transaksi
     */
    public function show(string $id)
    {
        $peminjaman = Peminjaman::with(['buku', 'anggota'])->findOrFail($id);

        // Gunakan view detail peminjaman yang sudah ada agar tidak error View Not Found
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Hapus riwayat Kas Denda
     */
    public function destroy(string $id)
    {
        $transaksi = Peminjaman::findOrFail($id);

        // Keamanan tambahan: Jika yang dihapus ternyata masih berstatus 'dipinjam', otomatis kembalikan stok buku
        if (strtolower(trim($transaksi->status)) == 'dipinjam' && $transaksi->buku) {
            $transaksi->buku->increment('stok', 1);
        }

        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Riwayat kas denda berhasil dihapus permanen!');
    }
}
