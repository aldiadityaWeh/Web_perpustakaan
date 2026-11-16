<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Stok Buku</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; color: #000; margin: 0; padding: 20px; font-size: 12px; }
        .kop-surat { text-align: center; border-bottom: 1px solid #888; padding-bottom: 12px; margin-bottom: 20px; }
        .kop-surat h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .kop-surat p { margin: 4px 0 0 0; font-size: 12px; }
        .judul-laporan { text-align: center; margin-bottom: 18px; font-size: 16px; }
        table { border-collapse: collapse; margin-bottom: 30px; width: 100%; border: 2px solid #000; }
        table th, table td { border: 1px solid #000; padding: 6px 8px; text-align: center; vertical-align: middle; font-size: 11px; }
        table th { font-weight: bold; background-color: #ffffff; }
        .text-center { text-align: center; }

        /* Area Tanda Tangan Dua Kolom (Kepala Perpustakaan & Kepala Sekolah) */
        .ttd-container { width: 100%; margin-top: 40px; display: table; page-break-inside: avoid; }
        .ttd-column { display: table-cell; width: 50%; text-align: center; vertical-align: top; }
        .ttd-space { height: 60px; }

        @media print {
            @page { size: landscape; margin: 1cm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- KOP SURAT DINAMIS -->
    <div class="kop-surat">
        <h1>{{ strtoupper($pengaturan->nama_sekolah ?? 'SEKOLAH') }}</h1>
        <p>PERPUSTAKAAN SEKOLAH</p>
        <p>{{ $pengaturan->alamat_sekolah ?? 'Alamat Belum Diatur' }}</p>
    </div>

    <!-- JUDUL LAPORAN SESUAI REFERENSI GAMBAR -->
    <div class="judul-laporan">
        @if(isset($request) && $request->filled('start_date') && $request->filled('end_date'))
            <strong>Laporan Stok Buku Periode</strong> {{ \Carbon\Carbon::parse($request->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($request->end_date)->format('d/m/Y') }}
        @else
            <strong>Laporan Stok Buku</strong> (Semua Periode)
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th width="11%">No Buku</th>
                <th width="12%">ISBN</th>
                <th width="18%">Judul Buku</th>
                <th width="14%">Katalog</th>
                <th width="13%">Pengarang</th>
                <th width="13%">Penerbit</th>
                <th width="8%">Tanggal<br>Penerimaan</th>
                <th width="5%">Jumlah<br>Buku</th>
                <th width="6%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalStok = 0;
                $kamusDDC = [
                    '000' => '000 - Karya Umum',
                    '100' => '100 - Filsafat & Psikologi',
                    '200' => '200 - Agama',
                    '300' => '300 - Ilmu Sosial',
                    '400' => '400 - Bahasa',
                    '500' => '500 - Sains & Matematika',
                    '600' => '600 - Ilmu Terapan / Teknologi',
                    '700' => '700 - Kesenian & Olahraga',
                    '800' => '800 - Kesusastraan',
                    '900' => '900 - Sejarah & Geografi',
                ];
            @endphp

            @forelse($buku as $index => $item)
                @php
                    // Generate Kode Buku otomatis seperti KDBK201218001 jika tidak ada kolom kode_buku
                    $tglKode = $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('dmy') : date('dmy');
                    $noBuku = $item->kode_buku ?? ('KDBK' . $tglKode . str_pad($item->id, 3, '0', STR_PAD_LEFT));

                    $kategoriBuku = $item->kategori;
                    $tampilKatalog = $kamusDDC[$kategoriBuku] ?? ($kategoriBuku ? ucfirst($kategoriBuku) : '-');
                    $totalStok += (int) $item->stok;
                @endphp
                <tr>
                    <td>{{ $noBuku }}</td>
                    <td>{{ $item->isbn ?? '-' }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $tampilKatalog }}</td>
                    <td>{{ $item->pengarang ?? '-' }}</td>
                    <td>{{ $item->penerbit ?? '-' }}</td>
                    <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>{{ $item->keterangan ?? ($item->lokasi_rak ? 'Rak ' . $item->lokasi_rak : '-') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 20px;">
                        Tidak ada data buku yang ditemukan pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if(count($buku) > 0)
        <tfoot>
            <tr>
                <th colspan="7" style="text-align: right; background-color: #f9f9f9;">Total Jumlah Buku:</th>
                <th style="background-color: #f9f9f9;">{{ $totalStok }}</th>
                <th style="background-color: #f9f9f9;">-</th>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- TANDA TANGAN DINAMIS (KEPALA PERPUSTAKAAN & KEPALA SEKOLAH) -->
    <div class="ttd-container">
        <!-- Kolom Kiri: Kepala Perpustakaan -->
        <div class="ttd-column">
            <p>Mengetahui,</p>
            <p>Kepala Perpustakaan</p>
            <div class="ttd-space"></div>
            <p style="font-weight: bold; text-decoration: underline;">{{ $pengaturan->kepala_perpustakaan ?? 'Nama Kepala Perpus' }}</p>
            <p>NIP. {{ $pengaturan->nip_kepala ?? '-' }}</p>
        </div>

        <!-- Kolom Kanan: Kepala Sekolah -->
        <div class="ttd-column">
            <p>Purwakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Kepala Sekolah</p>
            <div class="ttd-space"></div>
            <p style="font-weight: bold; text-decoration: underline;">{{ $pengaturan->kepala_sekolah ?? 'Nama Kepala Sekolah' }}</p>
            <p>NIP. {{ $pengaturan->nip_kepala_sekolah ?? '-' }}</p>
        </div>
    </div>

</body>
</html>
