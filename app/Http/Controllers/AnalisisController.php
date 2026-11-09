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
        $endDate   = $request->input('end_date', Carbon::now()->toDateString());

        $start = Carbon::parse($startDate)->startOfDay();
        $end   = Carbon::parse($endDate)->endOfDay();

        // Pengaman jika pengguna menginput tanggal awal lebih maju dari tanggal akhir
        if ($start->gt($end)) {
            [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
            $startDate = $start->toDateString();
            $endDate   = $end->toDateString();
        }

        // Gunakan (int) agar pembulatan hari pada Carbon v3 tetap bulat
        $diffInDays = (int) $start->diffInDays($end);

        // 2. SUMMARY CARDS BERDASARKAN RENTANG TANGGAL
        $totalTransaksi = Peminjaman::whereBetween('tanggal_pinjam', [$start, $end])->count();
        $bukuTerlambat  = Peminjaman::where('status', 'Dipinjam')
                                    ->whereDate('tanggal_jatuh_tempo', '<', Carbon::today())
                                    ->count();

        $totalAnggota        = Anggota::count();
        $anggotaPernahPinjam = Peminjaman::distinct('anggota_id')->count('anggota_id');
        $persenAnggota       = $totalAnggota > 0 ? min(100, round(($anggotaPernahPinjam / $totalAnggota) * 100)) : 0;

        $pembagiHari = $diffInDays >= 0 ? $diffInDays + 1 : 1;
        $rataPinjam  = round($totalTransaksi / $pembagiHari);

        // PERBAIKAN: Samakan rumus Total Kas dengan TransaksiController (Hanya yang Lunas)
        $totalKas = Peminjaman::where('status', 'Dikembalikan')
                              ->where('denda', '>', 0)
                              ->where('status_denda', 'Lunas')
                              ->sum('denda');

        // 3. LINE CHART (Tren Peminjaman Dinamis)
        $peminjamanHarian = Peminjaman::whereBetween('tanggal_pinjam', [$start, $end])
            ->select(DB::raw('DATE(tanggal_pinjam) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->pluck('total', 'date');

        $chartDates = [];
        $chartData  = [];

        for ($i = 0; $i <= $diffInDays; $i++) {
            $date         = $start->copy()->addDays($i);
            $dateStr      = $date->toDateString();
            $chartDates[] = $date->translatedFormat('d M');
            $chartData[]  = (int) ($peminjamanHarian[$dateStr] ?? 0);
        }

        // 4. DONUT CHART (Distribusi Kategori Buku dengan Label DDC)
        $mapKategori = [
            '000' => '000 - Komputer & Info',
            '100' => '100 - Filsafat & Psikologi',
            '200' => '200 - Agama',
            '300' => '300 - Ilmu Sosial',
            '400' => '400 - Bahasa',
            '500' => '500 - Sains & MTK',
            '600' => '600 - Teknologi Terapan',
            '700' => '700 - Seni & Olahraga',
            '800' => '800 - Kesusastraan',
            '900' => '900 - Sejarah & Geografi',
        ];

        $kategoriStats = Buku::select('kategori', DB::raw('count(*) as total'))
                             ->groupBy('kategori')
                             ->orderBy('kategori')
                             ->get();

        $labelKategori = [];
        $dataKategori  = [];
        foreach ($kategoriStats as $stat) {
            $kode            = (string) $stat->kategori;
            $labelKategori[] = $mapKategori[$kode] ?? ucfirst($kode ?: 'Umum');
            $dataKategori[]  = (int) $stat->total;
        }

        // 5. BUKU TERPOPULER (Berdasarkan rentang tanggal)
        $bukuPopuler = Peminjaman::whereBetween('tanggal_pinjam', [$start, $end])
                                 ->select('buku_id', DB::raw('count(*) as total_pinjam'))
                                 ->with('buku')
                                 ->groupBy('buku_id')
                                 ->orderByDesc('total_pinjam')
                                 ->take(5)
                                 ->get();

        // 6. TOP 5 ANGGOTA TERAKTIF (Berdasarkan rentang tanggal)
        $anggotaTeraktif = Peminjaman::whereBetween('tanggal_pinjam', [$start, $end])
                                     ->select('anggota_id', DB::raw('count(*) as total'))
                                     ->with('anggota')
                                     ->groupBy('anggota_id')
                                     ->orderByDesc('total')
                                     ->take(5)
                                     ->get();

        // 7. DAFTAR PEMINJAMAN TERBARU
        $peminjamanTerbaru = Peminjaman::with(['buku', 'anggota'])
                                       ->whereBetween('tanggal_pinjam', [$start, $end])
                                       ->latest('created_at')
                                       ->paginate(4)
                                       ->withQueryString();

        return view('admin.analisis.index', compact(
            'totalTransaksi', 'bukuTerlambat', 'persenAnggota', 'rataPinjam',
            'chartDates', 'chartData', 'labelKategori', 'dataKategori',
            'peminjamanTerbaru', 'bukuPopuler', 'startDate', 'endDate',
            'totalKas', 'anggotaTeraktif'
        ));
    }
}
