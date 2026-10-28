<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Peminjaman</title>
    <style>
        /* Gaya khusus untuk tampilan kertas cetak */
        body { font-family: 'Times New Roman', Times, serif; color: #000; margin: 0; padding: 20px; font-size: 12px; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; padding-bottom: 15px; margin-bottom: 20px; }
        .kop-surat h1 { margin: 0; font-size: 20px; text-transform: uppercase; }
        .kop-surat p { margin: 5px 0 0 0; font-size: 13px; }
        .judul-laporan { text-align: center; margin-bottom: 20px; font-weight: bold; font-size: 15px; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table th, table td { border: 1px solid #000; padding: 8px 10px; text-align: left; }
        table th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .text-center { text-align: center; }

        /* Area Tanda Tangan Dua Kolom (Kepala Perpustakaan & Kepala Sekolah) */
        .ttd-container { width: 100%; margin-top: 40px; display: table; page-break-inside: avoid; }
        .ttd-column { display: table-cell; width: 50%; text-align: center; vertical-align: top; }
        .ttd-space { height: 60px; }

        /* Hilangkan elemen yang tidak perlu saat di-print */
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

    <div class="judul-laporan">
        LAPORAN TRANSAKSI PEMINJAMAN BUKU<br>
        <span style="font-size: 12px; font-weight: normal;">
            @if(request('start_date') && request('end_date'))
                Periode: {{ \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }} s.d {{ \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}
            @else
                Semua Riwayat Transaksi
            @endif
        </span>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="25%">Nama Peminjam</th>
                <th width="30%">Judul Buku</th>
                <th width="10%">Status</th>
                <th width="15%">Denda</th>
            </tr>
        </thead>
        <tbody>
            @php $totalDenda = 0; @endphp
            @forelse($peminjaman as $index => $trx)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d/m/Y') }}</td>
                    <td>{{ $trx->anggota->nama_lengkap ?? '-' }}</td>
                    <td>{{ $trx->buku->judul ?? '-' }}</td>
                    <td class="text-center">{{ ucfirst($trx->status) }}</td>
                    <td style="text-align: right;">
                        @if($trx->denda > 0)
                            Rp {{ number_format($trx->denda, 0, ',', '.') }}
                            @php $totalDenda += $trx->denda; @endphp
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">Tidak ada transaksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        @if($totalDenda > 0)
        <tfoot>
            <tr>
                <th colspan="5" style="text-align: right;">Total Pemasukan Denda:</th>
                <th style="text-align: right;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</th>
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
