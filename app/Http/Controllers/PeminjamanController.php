<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar peminjaman
     */
    public function index()
    {
        // Ambil data peminjaman beserta relasi buku dan anggotanya
        $peminjamans = Peminjaman::with(['buku', 'anggota'])->latest()->paginate(10);
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    /**
     * Menampilkan form tambah peminjaman
     */
    public function create()
    {
        // Ambil buku stok > 0, urutkan judul, lalu KELOMPOKKAN berdasarkan 'kategori'
        $bukusByKategori = Buku::where('stok', '>', 0)->orderBy('judul', 'asc')->get()->groupBy('kategori');

        // Ambil anggota aktif, urutkan nama, KELOMPOKKAN berdasarkan 'kelas', lalu urutkan nama kelasnya (1A, 1B, dst)
        $anggotasByKelas = Anggota::where('status', 'Aktif')->orderBy('nama_lengkap', 'asc')->get()->groupBy('kelas')->sortKeys();

        return view('admin.peminjaman.create', compact('bukusByKategori', 'anggotasByKelas'));
    }

    /**
     * Menyimpan transaksi peminjaman baru & Mengurangi stok buku
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'anggota_id' => 'required|exists:anggota,id',
            'tanggal_jatuh_tempo' => 'required|date|after_or_equal:today',
            'catatan' => 'nullable|string'
        ]);

        // Cek Logika: Apakah siswa ini sedang meminjam buku yang sama dan belum dikembalikan?
        $sedangDipinjam = Peminjaman::where('anggota_id', $validated['anggota_id'])
                                    ->where('buku_id', $validated['buku_id'])
                                    ->where('status', 'dipinjam')
                                    ->exists();

        if ($sedangDipinjam) {
            return back()->withErrors(['buku_id' => 'Siswa ini masih meminjam buku tersebut dan belum mengembalikannya.'])->withInput();
        }

        // Ambil data buku untuk dicek ulang stoknya (berjaga-jaga)
        $buku = Buku::findOrFail($validated['buku_id']);
        if ($buku->stok < 1) {
            return back()->withErrors(['buku_id' => 'Maaf, stok buku habis.'])->withInput();
        }

        // Simpan Transaksi Peminjaman
        Peminjaman::create([
            'buku_id' => $validated['buku_id'],
            'anggota_id' => $validated['anggota_id'],
            'tanggal_pinjam' => Carbon::now()->toDateString(),
            'tanggal_jatuh_tempo' => $validated['tanggal_jatuh_tempo'],
            'status' => 'dipinjam',
            'catatan' => $validated['catatan']
        ]);

        // Kurangi stok buku secara otomatis
        $buku->decrement('stok', 1);

        return redirect()->route('peminjaman.index')->with('success', 'Transaksi peminjaman berhasil dicatat, dan stok buku otomatis berkurang!');
    }

    /**
     * Menghapus catatan peminjaman (Opsional, jika salah ketik/batal pinjam)
     */
    public function destroy(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Jika buku berstatus dipinjam lalu dihapus, kembalikan stok bukunya +1
        if ($peminjaman->status == 'dipinjam') {
            $buku = Buku::find($peminjaman->buku_id);
            if ($buku) {
                $buku->increment('stok', 1);
            }
        }

        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Data transaksi berhasil dihapus!');
    }
}
