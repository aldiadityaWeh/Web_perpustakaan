<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class KioskController extends Controller
{
    // 1. Tampilkan Halaman Input NIS
    public function index()
    {
        return view('admin.kiosk.peminjaman');
    }

    // 2. Validasi NIS dan Masuk ke Katalog
    public function authenticate(Request $request)
    {
        $request->validate(['nis' => 'required|string']);

        $anggota = Anggota::where('nis', $request->nis)->first();

        if (!$anggota) {
            return back()->with('error', 'NIS tidak ditemukan. Pastikan Anda sudah terdaftar.');
        }
        if ($anggota->status !== 'Aktif') {
            return back()->with('error', 'Status keanggotaan Anda tidak aktif. Hubungi Admin.');
        }

        // Simpan data siswa ke session sementara
        Session::put('kiosk_anggota_id', $anggota->id);
        Session::put('kiosk_anggota_nama', $anggota->nama_lengkap);

        return redirect()->route('kiosk.katalog');
    }

    // 3. Tampilkan Katalog Buku
    public function katalog()
    {
        // Pastikan sudah "login" pakai NIS
        if (!Session::has('kiosk_anggota_id')) {
            return redirect()->route('kiosk.index')->with('error', 'Silakan masukkan NIS terlebih dahulu.');
        }

        // Ambil data buku yang stoknya masih ada, lalu kelompokkan berdasarkan kategori
        $bukus = Buku::where('stok', '>', 0)->orderBy('judul', 'asc')->get()->groupBy('kategori');
        $pengaturan = Pengaturan::first() ?? new Pengaturan(['maksimal_buku_pinjam' => 3, 'maksimal_hari_pinjam' => 7]);

        return view('admin.kiosk.katalog', compact('bukus', 'pengaturan'));
    }

    // 4. Proses Peminjaman (Checkout)
    public function store(Request $request)
    {
        if (!Session::has('kiosk_anggota_id')) {
            return redirect()->route('kiosk.index');
        }

        $request->validate([
            'buku_ids' => 'required|array|min:1',
            'buku_ids.*' => 'exists:buku,id'
        ]);

        $anggota_id = Session::get('kiosk_anggota_id');
        $nama_siswa = Session::get('kiosk_anggota_nama');
        $pengaturan = Pengaturan::first() ?? new Pengaturan(['maksimal_hari_pinjam' => 7]);

        try {
            DB::transaction(function () use ($request, $anggota_id, $pengaturan) {
                foreach ($request->buku_ids as $buku_id) {
                    $buku = Buku::lockForUpdate()->find($buku_id);
                    if ($buku->stok > 0) {
                        Peminjaman::create([
                            'anggota_id' => $anggota_id,
                            'buku_id' => $buku_id,
                            'tanggal_pinjam' => Carbon::now(),
                            'tanggal_jatuh_tempo' => Carbon::now()->addDays($pengaturan->maksimal_hari_pinjam),
                            // Status kita buat 'Dipinjam', namun admin perlu mengecek fisiknya
                            'status' => 'Dipinjam'
                        ]);
                        $buku->decrement('stok');
                    }
                }
            });

            // Hapus session setelah berhasil meminjam
            Session::forget(['kiosk_anggota_id', 'kiosk_anggota_nama']);

            return redirect()->route('kiosk.index')->with('success', "Peminjaman atas nama {$nama_siswa} berhasil diajukan! Silakan bawa buku fisik Anda ke meja Admin untuk divalidasi.");

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem saat memproses peminjaman.');
        }
    }
}
