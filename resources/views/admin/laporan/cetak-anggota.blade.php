<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Data Anggota</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; color: #000; margin: 0; padding: 20px; font-size: 12px; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; padding-bottom: 15px; margin-bottom: 20px; }
        .kop-surat h1 { margin: 0; font-size: 20px; text-transform: uppercase; }
        .kop-surat p { margin: 5px 0 0 0; font-size: 13px; }
        .judul-laporan { text-align: center; margin-bottom: 20px; font-weight: bold; font-size: 15px; text-transform: uppercase; line-height: 1.5; }
        table { border-collapse: collapse; margin-bottom: 30px; width: 100%; border: 2px solid #000; }
        table th, table td { border: 1px solid #000; padding: 8px 10px; text-align: left; }
        table th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .text-center { text-align: center; }

        /* Area Tanda Tangan Dua Kolom (Kepala Perpustakaan & Kepala Sekolah) */
        .ttd-container { width: 100%; margin-top: 40px; display: table; page-break-inside: avoid; }
        .ttd-column { display: table-cell; width: 50%; text-align: center; vertical-align: top; }
        .ttd-space { height: 60px; }

        @media print {
            @page { margin: 1cm; }
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

    @php
        $klsFilter = $kelasDipilih ?? request('kelas', 'all');
        $labelKelas = ($klsFilter !== 'all' && $klsFilter !== 'semua' && $klsFilter !== '')
            ? 'KELAS ' . strtoupper($klsFilter)
            : 'SEMUA KELAS (ALL)';
    @endphp

    <div class="judul-laporan">
        LAPORAN DAFTAR ANGGOTA PERPUSTAKAAN ({{ $labelKelas }})<br>
        <span style="font-size: 12px; font-weight: normal; text-transform: none;">
            Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </span>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NIS</th>
                <th width="30%">Nama Lengkap</th>
                <th width="10%">Kelas</th>
                <th width="10%">L/P</th>
                <th width="30%">Tempat, Tanggal Lahir</th>
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
                    <td class="text-center">
                        {{ $siswa->tempat_lahir ?? '-' }},
                        @if($siswa->tanggal_lahir)
                            {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">
                        Tidak ada data anggota untuk filter {{ strtolower($labelKelas) }}.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if(count($anggota) > 0)
        <tfoot>
            <tr>
                <th colspan="5" style="text-align: right; background-color: #f9f9f9;">Total Anggota Terdaftar:</th>
                <th class="text-center" style="background-color: #f9f9f9;">{{ count($anggota) }} Siswa</th>
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
