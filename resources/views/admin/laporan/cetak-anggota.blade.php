<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Data Anggota</title>
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
        LAPORAN DAFTAR ANGGOTA PERPUSTAKAAN<br>
        <span style="font-size: 12px; font-weight: normal;">
            Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </span>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NIS / ID</th>
                <th width="35%">Nama Lengkap</th>
                <th width="15%">Kelas</th>
                <th width="15%">Jenis Kelamin</th>
                <th width="15%">Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($anggota as $index => $siswa)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $siswa->nis }}</td>
                    <td>{{ $siswa->nama_lengkap }}</td>
                    <td class="text-center">{{ $siswa->kelas ?? '-' }}</td>
                    <td class="text-center">{{ $siswa->jenis_kelamin ?? '-' }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($siswa->created_at)->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">Belum ada data anggota di dalam sistem.</td>
                </tr>
            @endforelse
        </tbody>
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
