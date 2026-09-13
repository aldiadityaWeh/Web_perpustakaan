<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data peminjaman beserta relasi nama anggota dan judul bukunya
        $query = Peminjaman::with(['anggota', 'buku']);

        // Logika Pencarian Peminjaman (Live Search)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('anggota', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%');
            })->orWhereHas('buku', function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%');
            })->orWhere('status', 'like', '%' . $search . '%');
        }

        // Logika Filter Tab (Semua, Dipinjam, Terlambat, Dikembalikan)
        if ($request->has('filter') && $request->filter != 'semua') {
            $filter = $request->filter;
            $hariIni = Carbon::today();

            if ($filter == 'dipinjam') {
                $query->where('status', 'Dipinjam')->whereDate('tanggal_jatuh_tempo', '>=', $hariIni);
            } elseif ($filter == 'terlambat') {
                $query->where('status', 'Dipinjam')->whereDate('tanggal_jatuh_tempo', '<', $hariIni);
            } elseif ($filter == 'dikembalikan') {
                $query->where('status', 'Dikembalikan');
            }
        }

        // Urutkan dari yang terbaru, batasi 10 baris per halaman
        $peminjamans = $query->latest()->paginate(10)->withQueryString();

        // Cek keterlambatan secara otomatis saat data dimuat (Virtual Status)
        foreach ($peminjamans as $pinjam) {
            $jatuhTempo = Carbon::parse($pinjam->tanggal_jatuh_tempo)->endOfDay();
            $sekarang = Carbon::now();

            if ($pinjam->status == 'Dipinjam' && $sekarang->gt($jatuhTempo)) {
                $pinjam->status_aktual = 'Terlambat';
                $pinjam->hari_terlambat = $sekarang->diffInDays($jatuhTempo);
            } else {
                $pinjam->status_aktual = $pinjam->status;
            }
        }

        if ($request->ajax()) {
            return view('admin.peminjaman.index', compact('peminjamans'));
        }

        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $anggotas = Anggota::where('status', 'Aktif')->orderBy('nama_lengkap', 'asc')->get();
        $bukus = Buku::where('stok', '>', 0)->orderBy('judul', 'asc')->get();

        return view('admin.peminjaman.create', compact('anggotas', 'bukus'));
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

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if($peminjaman->status == 'Dipinjam') {
            $peminjaman->buku->increment('stok');
        }

        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Riwayat peminjaman berhasil dibatalkan dan stok dikembalikan.');
    }
}
