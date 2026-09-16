<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalisisController extends Controller
{
    public function index(Request $request)
    {
        // 1. TENTUKAN RENTANG TANGGAL (Default: 7 Hari Terakhir)
        $startDate = $request->input('start_date', Carbon::now()->subDays(6)->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();
        $diffInDays = $start->diffInDays($end);

        // 2. SUMMARY CARDS BERDASARKAN RENTANG TANGGAL
        $totalTransaksi = Peminjaman::whereBetween('tanggal_pinjam', [$start, $end])->count();
        $bukuTerlambat = Peminjaman::where('status', 'terlambat')->count(); // Absolut saat ini

        $totalAnggota = Anggota::count();
        $anggotaPernahPinjam = Peminjaman::distinct('anggota_id')->count('anggota_id');
        $persenAnggota = $totalAnggota > 0 ? round(($anggotaPernahPinjam / $totalAnggota) * 100) : 0;

        $pembagiHari = $diffInDays > 0 ? $diffInDays + 1 : 1;
        $rataPinjam = round($totalTransaksi / $pembagiHari);

        // --- FITUR BARU: Total Kas Denda Keseluruhan ---
        $totalKas = Peminjaman::where('status', 'Dikembalikan')->sum('denda');

        // 3. LINE CHART (Tren Peminjaman Dinamis)
        $peminjamanHarian = Peminjaman::whereBetween('tanggal_pinjam', [$start, $end])
            ->select(DB::raw('DATE(tanggal_pinjam) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->pluck('total', 'date');

        $chartDates = [];
        $chartData = [];

        for ($i = 0; $i <= $diffInDays; $i++) {
            $date = $start->copy()->addDays($i);
            $dateStr = $date->toDateString();
            $chartDates[] = $date->translatedFormat('d M');
            $chartData[] = $peminjamanHarian[$dateStr] ?? 0;
        }

        // 4. DONUT CHART (Distribusi Kategori Buku)
        $kategoriStats = Buku::select('kategori', DB::raw('count(*) as total'))
                             ->groupBy('kategori')
                             ->get();

        $labelKategori = [];
        $dataKategori = [];
        foreach ($kategoriStats as $stat) {
            $labelKategori[] = ucfirst($stat->kategori);
            $dataKategori[] = $stat->total;
        }

        // 5. BUKU TERPOPULER (Berdasarkan rentang tanggal)
        $bukuPopuler = Peminjaman::whereBetween('tanggal_pinjam', [$start, $end])
                                 ->select('buku_id', DB::raw('count(*) as total_pinjam'))
                                 ->with('buku')
                                 ->groupBy('buku_id')
                                 ->orderByDesc('total_pinjam')
                                 ->take(5) // Diubah jadi 5 agar pas dengan UI
                                 ->get();

        // --- FITUR BARU: Top 5 Anggota Teraktif ---
        $anggotaTeraktif = Peminjaman::whereBetween('tanggal_pinjam', [$start, $end])
                                 ->select('anggota_id', DB::raw('count(*) as total'))
                                 ->groupBy('anggota_id')
                                 ->orderByDesc('total')
                                 ->take(5)
                                 ->with('anggota')
                                 ->get();

        // 6. DAFTAR PEMINJAMAN TERBARU
        $peminjamanTerbaru = Peminjaman::with(['buku', 'anggota'])
                                       ->latest('created_at')
                                       ->take(4) // Diubah jadi 4 agar UI seimbang
                                       ->get();

        return view('admin.analisis.index', compact(
            'totalTransaksi', 'bukuTerlambat', 'persenAnggota', 'rataPinjam',
            'chartDates', 'chartData', 'labelKategori', 'dataKategori',
            'peminjamanTerbaru', 'bukuPopuler', 'startDate', 'endDate',
            'totalKas', 'anggotaTeraktif'
        ));
    }
}
