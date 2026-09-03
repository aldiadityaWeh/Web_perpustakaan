<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    /**
     * Menampilkan daftar buku yang SEDANG DIPINJAM (Belum dikembalikan)
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['buku', 'anggota'])->where('status', 'dipinjam');

        // Logika Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Cari berdasarkan Nama Siswa
                $q->whereHas('anggota', function($subQ) use ($search) {
                    $subQ->where('nama_lengkap', 'like', '%' . $search . '%');
                })
                // Atau cari berdasarkan Judul Buku
                ->orWhereHas('buku', function($subQ) use ($search) {
                    $subQ->where('judul', 'like', '%' . $search . '%');
                });
            });
        }

        // Ambil data dan tambahkan withQueryString() agar filter pencarian tidak hilang saat pindah halaman (pagination)
        $peminjamans = $query->orderBy('tanggal_jatuh_tempo', 'asc')->paginate(10)->withQueryString();

        return view('admin.pengembalian.index', compact('peminjamans'));
    }

    /**
     * Memproses pengembalian buku, menghitung denda, dan mengembalikan stok
     */
    public function update(Request $request, string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Mencegah double klik / proses
        if ($peminjaman->status != 'dipinjam') {
            return back()->withErrors(['pesan' => 'Buku ini sudah dikembalikan sebelumnya.']);
        }

        $hariIni = Carbon::now()->startOfDay();
        $tglJatuhTempo = Carbon::parse($peminjaman->tanggal_jatuh_tempo)->startOfDay();
        $denda = 0;
        $status = 'dikembalikan';

        // Cek Keterlambatan
        if ($hariIni->greaterThan($tglJatuhTempo)) {
            $selisihHari = $hariIni->diffInDays($tglJatuhTempo);
            $denda = $selisihHari * 500; // Contoh denda: Rp 500 per hari
            $status = 'terlambat';
        }

        // Update data transaksi
        $peminjaman->update([
            'tanggal_kembali' => Carbon::now()->toDateString(),
            'status' => $status,
            'denda' => $denda,
        ]);

        // Kembalikan stok buku (+1)
        $buku = Buku::find($peminjaman->buku_id);
        if ($buku) {
            $buku->increment('stok', 1);
        }

        $pesan = 'Buku berhasil dikembalikan. Stok bertambah!';
        if ($denda > 0) {
            $pesan = 'Buku dikembalikan dengan TERLAMBAT. Denda: Rp ' . number_format($denda, 0, ',', '.');
        }

        return redirect()->route('pengembalian.index')->with('success', $pesan);
    }
}
