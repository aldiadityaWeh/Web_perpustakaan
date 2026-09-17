<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Inventaris Buku</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; color: #000; margin: 0; padding: 20px; font-size: 12px; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; padding-bottom: 15px; margin-bottom: 20px; }
        .kop-surat h1 { margin: 0; font-size: 22px; text-transform: uppercase; }
        .kop-surat p { margin: 5px 0 0 0; font-size: 14px; }
        .judul-laporan { text-align: center; margin-bottom: 20px; font-weight: bold; font-size: 16px; text-transform: uppercase; }
        table { border-collapse: collapse; margin-bottom: 30px; width: 100%; }
        table th, table td { border: 1px solid #000; padding: 8px 10px; text-align: left; }
        table th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .text-center { text-align: center; }
        .ttd-area { float: right; width: 250px; text-align: center; margin-top: 30px; }

        @media print {
            @page { margin: 1cm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- KOP SURAT -->
   <div class="kop-surat">
        <h1>PERPUSTAKAAN {{ strtoupper($pengaturan->nama_sekolah ?? 'SEKOLAH') }}</h1>
        <p>{{ $pengaturan->alamat_sekolah ?? 'Alamat Belum Diatur' }}</p>
    </div>

    <div class="judul-laporan">
        LAPORAN INVENTARIS BUKU PERPUSTAKAAN<br>
        <span style="font-size: 12px; font-weight: normal;">
            Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </span>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Judul Buku</th>
                <th width="20%">Kategori (DDC)</th>
                <th width="15%">Pengarang / Penerbit</th>
                <th width="15%">Tahun Terbit</th>
                <th width="10%">Sisa Stok</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalStok = 0;
                // Kamus Klasifikasi DDC Standar Perpustakaan
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
                    // Cek apakah data kategori di database cocok dengan kode DDC
                    // Jika cocok, pakai nama DDC lengkap. Jika tidak, tampilkan apa adanya dari database.
                    $kategoriBuku = $item->kategori;
                    $tampilKategori = $kamusDDC[$kategoriBuku] ?? ucfirst($kategoriBuku);
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->judul }}</td>
                    <!-- Menampilkan Kategori DDC -->
                    <td class="text-center" style="font-size: 11px;">{{ $tampilKategori }}</td>
                    <td>{{ $item->pengarang ?? '-' }} <br> <span style="font-size: 10px; color: #555;">{{ $item->penerbit ?? '' }}</span></td>
                    <td class="text-center">{{ $item->tahun_terbit ?? '-' }}</td>
                    <td class="text-center">
                        <strong>{{ $item->stok }}</strong>
                        @php $totalStok += $item->stok; @endphp
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">Belum ada data buku di dalam sistem.</td>
                </tr>
            @endforelse
        </tbody>
        @if(count($buku) > 0)
        <tfoot>
            <tr>
                <th colspan="5" style="text-align: right;">Total Keseluruhan Buku Fisik Tersedia:</th>
                <th class="text-center">{{ $totalStok }}</th>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- Tanda Tangan -->
    <div class="ttd-area">
        <p>Purwakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Kepala Perpustakaan,</p>
        <br><br><br><br>
        <p style="font-weight: bold; text-decoration: underline;">{{ $pengaturan->kepala_perpustakaan ?? 'Admin' }}</p>
        <p>NIP. {{ $pengaturan->nip_kepala ?? '-' }}</p>
    </div>

</body>
</html>
