<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Buku</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12px; color: #000; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1, .header h2 { margin: 0; padding: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; }
        .footer-ttd { width: 100%; margin-top: 50px; }
        .footer-ttd td { border: none; text-align: right; padding-right: 50px; }
    </style>
</head>
<body onload="window.print()"> <!-- Otomatis membuka dialog Print -->

    <!-- Kop Surat -->
    <div class="header">
        <h2>PERPUSTAKAAN SEKOLAH</h2>
        <h1>SDN 6 CISEREUH</h1>
        <p>Alamat: Jl. Pendidikan No.123, Kabupaten Purwakarta</p>
    </div>

    <h3 style="text-align: center;">LAPORAN DATA INVENTARIS BUKU</h3>
    <p>Kategori Filter: <b>{{ $kategori && $kategori != 'semua' ? ucfirst($kategori) : 'Semua Kategori' }}</b></p>

    <!-- Tabel Data Buku -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Judul Buku</th>
                <th style="width: 15%;">ISBN</th>
                <th style="width: 20%;">Pengarang & Penerbit</th>
                <th style="width: 15%;">Kategori</th>
                <th style="width: 10%;">Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $buku)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td><b>{{ $buku->judul }}</b></td>
                <td>{{ $buku->isbn }}</td>
                <td>{{ $buku->pengarang }} <br> <i>({{ $buku->penerbit }})</i></td>
                <td style="text-align: center;">{{ ucfirst($buku->kategori) }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $buku->stok }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data buku pada kategori ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    <table class="footer-ttd">
        <tr>
            <td>
                Purwakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                Kepala Perpustakaan,<br><br><br><br>
                <b>Budi Sudarsono, S.Pd</b><br>
                NIP. 19801234 200501 1 001
            </td>
        </tr>
    </table>

</body>
</html>
