<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Anggota;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    // 1. Laporan Peminjaman
    public function peminjaman(Request $request)
    {
        $startDate = $request->start_date ?? Carbon::now()->startOfMonth()->toDateString();
        $endDate = $request->end_date ?? Carbon::now()->endOfMonth()->toDateString();
        $type = $request->type; // 'pdf' atau 'excel'

        $data = Peminjaman::with(['buku', 'anggota'])
            ->whereBetween('tanggal_pinjam', [$startDate, $endDate])
            ->get();

        if ($type == 'excel') {
            return $this->exportCsv($data, 'peminjaman', ['ID', 'Nama Siswa', 'Buku', 'Tgl Pinjam', 'Tgl Kembali', 'Status']);
        }

        return view('admin.laporan.cetak-peminjaman', compact('data', 'startDate', 'endDate'));
    }
    // 2. Laporan Buku
    public function buku(Request $request)
    {
        $kategori = $request->kategori;
        $type = $request->type;

        $query = Buku::query();
        if ($kategori && $kategori != 'semua') {
            $query->where('kategori', $kategori);
        }
        $data = $query->get();

        if ($type == 'excel') {
            return $this->exportCsv($data, 'buku', ['Judul', 'ISBN', 'Pengarang', 'Penerbit', 'Kategori', 'Stok']);
        }

        return view('admin.laporan.cetak-buku', compact('data', 'kategori'));
    }

    // 3. Laporan Anggota
    public function anggota(Request $request)
    {
        $kelas = $request->kelas;
        $type = $request->type;

        $query = Anggota::query();
        if ($kelas && $kelas != 'semua') {
            $query->where('kelas', $kelas);
        }
        $data = $query->get();

        if ($type == 'excel') {
            return $this->exportCsv($data, 'anggota', ['NIS', 'Nama Lengkap', 'Kelas', 'L/P', 'Status']);
        }

        return view('admin.laporan.cetak-anggota', compact('data', 'kelas'));
    }

    // Fungsi Bantuan untuk Download Excel (CSV)
    private function exportCsv($data, $namaFile, $headersArray)
    {
        $fileName = "Laporan_{$namaFile}_" . date('Ymd') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($data, $headersArray, $namaFile) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headersArray); // Header kolom

            foreach ($data as $row) {
                if ($namaFile == 'peminjaman') {
                    fputcsv($file, [$row->id, $row->anggota->nama_lengkap ?? '-', $row->buku->judul ?? '-', $row->tanggal_pinjam, $row->tanggal_kembali ?? 'Belum', $row->status]);
                } elseif ($namaFile == 'buku') {
                    fputcsv($file, [$row->judul, $row->isbn, $row->pengarang, $row->penerbit, $row->kategori, $row->stok]);
                } elseif ($namaFile == 'anggota') {
                    fputcsv($file, [$row->nis, $row->nama_lengkap, $row->kelas, $row->jenis_kelamin, $row->status]);
                }
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
