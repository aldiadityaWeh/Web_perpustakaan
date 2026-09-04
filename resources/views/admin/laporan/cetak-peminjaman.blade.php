<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Peminjaman</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12px; color: #000; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1, .header h2 { margin: 0; padding: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer-ttd { width: 100%; margin-top: 50px; }
        .footer-ttd td { border: none; text-align: right; padding-right: 50px; }
    </style>
</head>
<body onload="window.print()"> <!-- Otomatis memunculkan dialog Print/Save to PDF saat dibuka -->

    <div class="header">
        <h2>PERPUSTAKAAN SEKOLAH</h2>
        <h1>SDN 6 CISEREUH</h1>
        <p>Alamat: Jl. Pendidikan No.123, Kabupaten Purwakarta</p>
    </div>

    <h3 style="text-align: center;">LAPORAN TRANSAKSI PEMINJAMAN</h3>
    <p>Periode: <b>{{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }}</b> s/d <b>{{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}</b></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tgl Pinjam</th>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $trx)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d-m-Y') }}</td>
                <td>{{ $trx->anggota->nama_lengkap ?? '-' }}</td>
                <td>{{ $trx->buku->judul ?? '-' }}</td>
                <td>{{ ucfirst($trx->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table class="footer-ttd">
        <tr>
            <td>
                Purwakarta, {{ \Carbon\Carbon::now()->format('d F Y') }}<br>
                Kepala Perpustakaan,<br><br><br><br>
                <b>Budi Sudarsono, S.Pd</b><br>
                NIP. 19801234 200501 1 001
            </td>
        </tr>
    </table>

</body>
</html>
