<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Pengaturan; // <-- Model Pengaturan dipanggil
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
   public function index(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('anggota', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%');
            })->orWhereHas('buku', function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%');
            })->orWhere('status', 'like', '%' . $search . '%');
        }

        if ($request->has('filter') && $request->filter != 'semua') {
            $filter = $request->filter;
            $hariIni = \Carbon\Carbon::today();

            if ($filter == 'dipinjam') {
                $query->where('status', 'Dipinjam')->whereDate('tanggal_jatuh_tempo', '>=', $hariIni);
            } elseif ($filter == 'terlambat') {
                $query->where('status', 'Dipinjam')->whereDate('tanggal_jatuh_tempo', '<', $hariIni);
            } elseif ($filter == 'dikembalikan') {
                $query->where('status', 'Dikembalikan');
            }
        }

        $peminjamans = $query->latest()->paginate(6)->withQueryString();

        // ❌ HAPUS SEMUA FOREACH DAN LOGIKA CARBON DI SINI! Model sudah otomatis menghitungnya.

        if ($request->ajax()) {
            return view('admin.peminjaman.index', compact('peminjamans'));
        }

        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $anggotas = Anggota::where('status', 'Aktif')->orderBy('nama_lengkap', 'asc')->get();
        $bukus = Buku::where('stok', '>', 0)->orderBy('judul', 'asc')->get();

        // Bawa data pengaturan agar bisa dibaca di halaman Create (jika nanti butuh untuk JavaScript)
        $pengaturan = Pengaturan::first() ?? new Pengaturan(['maksimal_hari_pinjam' => 7]);

        return view('admin.peminjaman.create', compact('anggotas', 'bukus', 'pengaturan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'buku_id' => 'required|array|min:1',
            'buku_id.*' => 'required|exists:buku,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ], [
            'buku_id.required' => 'Pilih minimal 1 buku untuk dipinjam.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali tidak boleh mundur dari tanggal pinjam.'
        ]);

        // Panggil data Pengaturan (Batas Hari & Batas Buku)
        $pengaturan = Pengaturan::first() ?? new Pengaturan([
            'maksimal_buku_pinjam' => 3,
            'maksimal_hari_pinjam' => 7
        ]);

        // 1. FITUR DINAMIS: CEK BATAS MAKSIMAL HARI PINJAM
        $tglPinjam = Carbon::parse($request->tanggal_pinjam)->startOfDay();
        $tglKembali = Carbon::parse($request->tanggal_kembali)->startOfDay();
        $durasiPinjam = $tglPinjam->diffInDays($tglKembali);

        if ($durasiPinjam > $pengaturan->maksimal_hari_pinjam) {
            return back()->withErrors([
                'tanggal_kembali' => "Batas maksimal peminjaman adalah {$pengaturan->maksimal_hari_pinjam} hari. Anda menginput durasi $durasiPinjam hari."
            ])->withInput();
        }

        // 2. FITUR DINAMIS: CEK BATAS MAKSIMAL BUKU YANG BOLEH DIPINJAM
        $sedangDipinjam = Peminjaman::where('anggota_id', $request->anggota_id)
                                    ->where('status', 'Dipinjam')
                                    ->count();
        $akanDipinjam = count($request->buku_id);

        if (($sedangDipinjam + $akanDipinjam) > $pengaturan->maksimal_buku_pinjam) {
            $sisaKuota = $pengaturan->maksimal_buku_pinjam - $sedangDipinjam;

            if ($sedangDipinjam == 0) {
                $pesanError = "Peminjaman ditolak. Anda mencoba meminjam $akanDipinjam buku sekaligus, padahal batas maksimal peminjaman hanya {$pengaturan->maksimal_buku_pinjam} buku per siswa.";
            } else if ($sisaKuota <= 0) {
                $pesanError = "Peminjaman ditolak. Siswa ini telah mencapai batas maksimal pinjaman ({$pengaturan->maksimal_buku_pinjam} buku) yang belum dikembalikan.";
            } else {
                $pesanError = "Peminjaman ditolak. Siswa ini masih memiliki tunggakan $sedangDipinjam buku. Sisa kuota pinjamannya saat ini hanya $sisaKuota buku lagi.";
            }

            return back()->withErrors(['error_sistem' => $pesanError])->withInput();
        }

        // PROSES SIMPAN KE DATABASE
        try {
            DB::transaction(function () use ($request) {
                foreach ($request->buku_id as $buku_id) {
                    $buku = Buku::lockForUpdate()->findOrFail($buku_id);

                    if ($buku->stok <= 0) {
                        throw new \Exception("Maaf, stok buku '{$buku->judul}' habis saat sedang diproses.");
                    }

                    Peminjaman::create([
                        'anggota_id' => $request->anggota_id,
                        'buku_id' => $buku_id,
                        'tanggal_pinjam' => $request->tanggal_pinjam,
                        'tanggal_jatuh_tempo' => $request->tanggal_kembali,
                        'status' => 'Dipinjam',
                    ]);

                    $buku->decrement('stok');
                }
            });

            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diproses. Stok buku telah dikurangi otomatis.');

        } catch (\Exception $e) {
            return back()->withErrors(['error_sistem' => $e->getMessage()])->withInput();
        }
    }

   public function show($id)
    {
        $peminjaman = Peminjaman::with(['buku', 'anggota'])->findOrFail($id);

        // ❌ LOGIKA DENDA DIHAPUS DARI SINI

        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if($peminjaman->status == 'Dipinjam') {
            $peminjaman->buku->increment('stok');
        }

        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Riwayat peminjaman berhasil dibatalkan dan stok dikembalikan.');
    }

    public function formKembali($id)
    {
        $peminjaman = Peminjaman::with(['buku', 'anggota'])->findOrFail($id);

        // ❌ LOGIKA DENDA DIHAPUS DARI SINI

        return view('admin.peminjaman.kembali', compact('peminjaman'));
    }

    public function formValidasi($id)
    {
        $peminjaman = Peminjaman::with(['buku', 'anggota'])->findOrFail($id);

        // ❌ LOGIKA DENDA DIHAPUS DARI SINI

        return view('admin.peminjaman.validasi', compact('peminjaman'));
    }

    public function prosesValidasi(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $request->validate([
            'kondisi_buku' => 'required|in:Baik,Rusak,Hilang',
            'denda' => 'required|numeric|min:0',
            'catatan' => 'nullable|string'
        ]);

        $catatanAkhir = $request->catatan;
        if ($request->kondisi_buku != 'Baik') {
            $catatanAkhir = "Kondisi Buku: " . $request->kondisi_buku . " | " . $request->catatan;
        }

        $peminjaman->update([
            'status' => 'Dikembalikan',
            'denda' => $request->denda,
            'catatan' => $catatanAkhir,
        ]);

        if ($request->kondisi_buku != 'Hilang') {
            $peminjaman->buku->increment('stok');
        }

        return redirect()->route('peminjaman.index')->with('success', 'Pengembalian buku berhasil divalidasi dan disimpan!');
    }
}
