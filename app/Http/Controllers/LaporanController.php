<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function peminjaman(Request $request)
    {
        // 1. PERBAIKAN LOGIKA: Wajibkan isi tanggal dan cegah tanggal terbalik
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ], [
            'start_date.required' => 'Pilih tanggal awal laporan terlebih dahulu.',
            'end_date.required'   => 'Pilih tanggal akhir laporan terlebih dahulu.',
            'end_date.after_or_equal' => 'Logika salah: Tanggal akhir tidak boleh lebih mundur dari tanggal awal.',
        ]);

        // 2. Format tanggal mencakup dari jam 00:00:00 sampai 23:59:59
        $start = Carbon::parse($request->start_date)->startOfDay();
        $end   = Carbon::parse($request->end_date)->endOfDay();

        // 3. Tarik data sesuai rentang tanggal
        $peminjaman = Peminjaman::with(['buku', 'anggota'])
            ->whereBetween('tanggal_pinjam', [$start, $end])
            ->latest('tanggal_pinjam')
            ->get();

        $pengaturan = Pengaturan::first() ?? new Pengaturan();

        // 4. JIKA USER MEMILIH FORMAT EXCEL
        if ($request->has('export') && $request->export == 'excel') {
            return $this->exportExcelSirkulasi($peminjaman, $request->start_date, $request->end_date, $pengaturan);
        }

        return view('admin.laporan.cetak-peminjaman', compact('peminjaman', 'request', 'pengaturan'));
    }

    public function buku(Request $request)
    {
        $buku = Buku::orderBy('judul')->get();
        $pengaturan = Pengaturan::first() ?? new Pengaturan();

        // JIKA USER MEMILIH FORMAT EXCEL
        if ($request->has('export') && $request->export == 'excel') {
            return $this->exportExcelBuku($buku, $pengaturan);
        }

        return view('admin.laporan.cetak-buku', compact('buku', 'pengaturan'));
    }

    public function anggota(Request $request)
    {
        $anggota = Anggota::orderBy('nama_lengkap')->get();
        $pengaturan = Pengaturan::first() ?? new Pengaturan();

        // JIKA USER MEMILIH FORMAT EXCEL
        if ($request->has('export') && $request->export == 'excel') {
            return $this->exportExcelAnggota($anggota, $pengaturan);
        }

        return view('admin.laporan.cetak-anggota', compact('anggota', 'pengaturan'));
    }

    // --- FUNGSI PRIVAT UNTUK PROSES EXCEL (.XLS) ---

    private function exportExcelSirkulasi($peminjaman, $startDate, $endDate, $pengaturan)
    {
        $filename = "Laporan_Sirkulasi_{$startDate}_sampai_{$endDate}.xls";

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        echo "<table border='1'>";
        echo "<tr><th colspan='7' style='font-size:16px; font-weight:bold;'>REKAP LAPORAN SIRKULASI PEMINJAMAN</th></tr>";
        echo "<tr><th colspan='7'>Instansi: {$pengaturan->nama_sekolah}</th></tr>";
        echo "<tr><th colspan='7'>Periode: {$startDate} s/d {$endDate}</th></tr>";
        echo "<tr><td colspan='7'></td></tr>";
        echo "<tr style='background-color:#f2f2f2; font-weight:bold;'>";
        echo "<th>No</th><th>Tanggal Pinjam</th><th>Nama Siswa</th><th>NIS</th><th>Judul Buku</th><th>Status</th><th>Denda (Rp)</th>";
        echo "</tr>";

        $totalDendaKeseluruhan = 0;

        foreach ($peminjaman as $index => $item) {
            $totalDendaKeseluruhan += $item->denda;
            echo "<tr>";
            echo "<td>" . ($index + 1) . "</td>";
            echo "<td>" . $item->tanggal_pinjam . "</td>";
            echo "<td>" . ($item->anggota->nama_lengkap ?? '-') . "</td>";
            echo "<td>'" . ($item->anggota->nis ?? '-') . "</td>";
            echo "<td>" . ($item->buku->judul ?? '-') . "</td>";
            echo "<td>" . $item->status . "</td>";
            echo "<td>" . $item->denda . "</td>";
            echo "</tr>";
        }

        // --- TAMBAHKAN BARIS TOTAL KESELURUHAN DI BAWAH ---
        echo "<tr style='background-color:#e6e6e6; font-weight:bold;'>";
        echo "<colspan='6' style='text-align:right;'>TOTAL KESELURUHAN DENDA:</td>";
        echo "<td>Rp " . number_format($totalDendaKeseluruhan, 0, ',', '.') . "</td>";
        echo "</tr>";

        echo "</table>";
        exit;
    }

    private function exportExcelBuku($buku, $pengaturan)
    {
        $filename = "Inventaris_Buku_" . date('Y-m-d') . ".xls";

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        echo "<table border='1'>";
        echo "<tr><th colspan='6' style='font-size:16px; font-weight:bold;'>LAPORAN INVENTARIS BUKU PERPUSTAKAAN</th></tr>";
        echo "<tr><th colspan='6'>Instansi: {$pengaturan->nama_sekolah}</th></tr>";
        echo "<tr><td colspan='6'></td></tr>";
        echo "<tr style='background-color:#f2f2f2; font-weight:bold;'>";
        echo "<th>No</th><th>Judul Buku</th><th>ISBN</th><th>Pengarang</th><th>Kategori DDC</th><th>Stok</th>";
        echo "</tr>";

        foreach ($buku as $index => $item) {
            echo "<tr>";
            echo "<td>" . ($index + 1) . "</td>";
            echo "<td>" . $item->judul . "</td>";
            echo "<td>'" . $item->isbn . "</td>";
            echo "<td>" . $item->pengarang . "</td>";
            echo "<td>" . $item->kategori . "</td>";
            echo "<td>" . $item->stok . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        exit;
    }

    private function exportExcelAnggota($anggota, $pengaturan)
    {
        $filename = "Data_Anggota_" . date('Y-m-d') . ".xls";

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        echo "<table border='1'>";
        echo "<tr><th colspan='6' style='font-size:16px; font-weight:bold;'>LAPORAN DATA ANGGOTA PERPUSTAKAAN</th></tr>";
        echo "<tr><th colspan='6'>Instansi: {$pengaturan->nama_sekolah}</th></tr>";
        echo "<tr><td colspan='6'></td></tr>";
        echo "<tr style='background-color:#f2f2f2; font-weight:bold;'>";
        echo "<th>No</th><th>Nama Lengkap</th><th>NIS</th><th>Kelas</th><th>Jenis Kelamin</th><th>Status</th>";
        echo "</tr>";

        foreach ($anggota as $index => $item) {
            echo "<tr>";
            echo "<td>" . ($index + 1) . "</td>";
            echo "<td>" . $item->nama_lengkap . "</td>";
            echo "<td>'" . $item->nis . "</td>";
            echo "<td>" . $item->kelas . "</td>";
            echo "<td>" . $item->jenis_kelamin . "</td>";
            echo "<td>" . $item->status . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        exit;
    }
}

