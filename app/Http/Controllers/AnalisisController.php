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

        $bukuTerlambat = Peminjaman::where('status', 'terlambat')->count(); // Buku terlambat tetap absolut (saat ini)

        $totalAnggota = Anggota::count();
        $anggotaPernahPinjam = Peminjaman::distinct('anggota_id')->count('anggota_id');
        $persenAnggota = $totalAnggota > 0 ? round(($anggotaPernahPinjam / $totalAnggota) * 100) : 0;

        // Rata-rata pinjam per hari dalam rentang waktu tersebut
        $pembagiHari = $diffInDays > 0 ? $diffInDays + 1 : 1;
        $rataPinjam = round($totalTransaksi / $pembagiHari);

        // 3. LINE CHART (Tren Peminjaman Dinamis)
        // Ambil data secara efisien pakai Group By
        $peminjamanHarian = Peminjaman::whereBetween('tanggal_pinjam', [$start, $end])
            ->select(DB::raw('DATE(tanggal_pinjam) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->pluck('total', 'date');

        $chartDates = [];
        $chartData = [];

        // Loop dari tanggal mulai sampai tanggal akhir
        for ($i = 0; $i <= $diffInDays; $i++) {
            $date = $start->copy()->addDays($i);
            $dateStr = $date->toDateString();

            // Format tanggal (contoh: 01 Sep)
            $chartDates[] = $date->translatedFormat('d M');
            $chartData[] = $peminjamanHarian[$dateStr] ?? 0; // Jika tidak ada peminjaman, set 0
        }

        // 4. DONUT CHART (Distribusi Kategori Buku - Keseluruhan Inventaris)
        $kategoriStats = Buku::select('kategori', DB::raw('count(*) as total'))
                             ->groupBy('kategori')
                             ->get();

        $labelKategori = [];
        $dataKategori = [];
        foreach ($kategoriStats as $stat) {
            $labelKategori[] = ucfirst($stat->kategori);
            $dataKategori[] = $stat->total;
        }

        // 5. BUKU TERPOPULER (Berdasarkan rentang tanggal yang difilter)
        $bukuPopuler = Peminjaman::whereBetween('tanggal_pinjam', [$start, $end])
                                 ->select('buku_id', DB::raw('count(*) as total_pinjam'))
                                 ->with('buku')
                                 ->groupBy('buku_id')
                                 ->orderByDesc('total_pinjam')
                                 ->take(3)
                                 ->get();

        // 6. DAFTAR PEMINJAMAN TERBARU (Keseluruhan)
        $peminjamanTerbaru = Peminjaman::with(['buku', 'anggota'])
                                       ->latest('created_at')
                                       ->take(3)
                                       ->get();

        return view('admin.analisis.index', compact(
            'totalTransaksi',
            'bukuTerlambat',
            'persenAnggota',
            'rataPinjam',
            'chartDates',
            'chartData',
            'labelKategori',
            'dataKategori',
            'peminjamanTerbaru',
            'bukuPopuler',
            'startDate',
            'endDate'
        ));
    }
}
