<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Logika untuk fitur pencarian (Live Search)
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
        $pengembalians = $query->latest('updated_at')->paginate(10)->withQueryString();

        // Jika request dari JavaScript (Live Search), kembalikan hanya bagian tabelnya
        if ($request->ajax()) {
            return view('admin.pengembalian.index', compact('pengembalians'));
        }

        // Tampilan normal halaman penuh
        return view('admin.pengembalian.index', compact('pengembalians'));
    }

    // =====================================================================
    // 2. FUNGSI STORE: Mengeksekusi Tombol Verifikasi "Belum Kembali"
    // =====================================================================
    public function store(string $id)
    {
        // 1. Cari data peminjamannya berdasarkan ID yang diklik, ambil juga relasi bukunya
        $pinjam = Peminjaman::with('buku')->findOrFail($id);

        // 2. Cek Keamanan: Mencegah error jika admin mengklik tombol 2x berturut-turut
        if ($pinjam->status == 'Dikembalikan') {
            return back()->with('error', 'Peringatan: Buku ini sudah diverifikasi pengembaliannya.');
        }

        try {
            // Gunakan DB Transaction agar jika ada error di tengah jalan, stok tidak terlanjur rusak
            DB::transaction(function () use ($pinjam) {

                // 3. Ubah status di tabel peminjaman menjadi 'Dikembalikan'
                $pinjam->update([
                    'status' => 'Dikembalikan'
                ]);

                // 4. Tambah (+1) stok buku kembali ke dalam inventaris perpustakaan
                if ($pinjam->buku) {
                    $pinjam->buku->increment('stok');
                }
            });

            // 5. Kembali ke halaman Peminjaman dengan notifikasi hijau
            return back()->with('success', 'Verifikasi Sukses! Buku berhasil dikembalikan dan stok otomatis bertambah.');

        } catch (\Exception $e) {
            // 6. Jika server error, batalkan semua dan tampilkan notifikasi merah
            return back()->with('error', 'Terjadi kesalahan pada sistem database: ' . $e->getMessage());
        }
    }
}
