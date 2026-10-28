<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Anggota</title>

    <!-- Menggunakan Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        @media print {
            @page {
                size: A4;
                margin: 1cm;
            }
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                background-color: white !important;
            }
            .no-print {
                display: none !important;
            }
        }

        .print-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5cm;
            justify-content: flex-start;
            max-width: 21cm;
            margin: 0 auto;
        }

        .kartu {
            width: 9cm;
            height: 5.5cm;
            background-color: #e2b34c;
            border: 1px solid #000;
            padding: 0.3cm;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
            color: #222;
            position: relative;
            overflow: hidden;
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .kop {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #222;
            padding-bottom: 4px;
            margin-bottom: 6px;
        }

        .kop-logo {
            width: 1.3cm;
            height: auto;
            margin-right: 8px;
        }

        .kop-text {
            flex: 1;
            text-align: left;
            line-height: 1.1;
        }

        .kop-text .baris-1 { font-size: 10px; font-weight: bold; color: #333; }
        .kop-text .baris-2 { font-size: 11px; font-weight: 900; color: #111; }
        .kop-text .baris-3 { font-size: 8px; color: #333; margin-top: 1px; }

        .judul-kartu {
            text-align: center;
            font-size: 11px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }

        .body-kartu {
            display: flex;
            justify-content: space-between;
        }

        .ttd-section {
            width: 35%;
            font-size: 8px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-top: 4px;
        }

        .ttd-space { height: 28px; }
        .data-section { width: 65%; font-size: 8.5px; color: #111; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table td { vertical-align: top; padding: 1.2px 0; font-weight: 600; }
        .col-label { width: 42%; }
        .col-titik { width: 4%; text-align: center; }
        .col-value { width: 54%; }
    </style>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-4xl mx-auto mb-6 no-print flex flex-col sm:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Cetak Kartu Anggota</h2>
            <p class="text-sm text-gray-500 mt-1">
                Menampilkan <b>{{ count($anggota) }}</b> kartu anggota. Centang <b>"Background graphics"</b> pada setelan Print.
            </p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.close()" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-5 py-2.5 rounded-lg font-bold transition-all shadow-sm">
                Batal
            </button>
            <button onclick="window.print()" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2.5 rounded-lg font-bold flex items-center gap-2 shadow-md transition-all">
                <i class="ph ph-printer text-xl"></i> Print Sekarang
            </button>
        </div>
    </div>

    <div class="print-container">
        @foreach($anggota as $a)
            @php
                // MENGAMBIL DATA DARI TABEL PENGATURAN SECARA DINAMIS
                $pengaturanData = \App\Models\Pengaturan::first();

                $namaSekolah   = $pengaturanData->nama_sekolah ?? 'SD NEGERI 6 CISEUREUH';
                $alamatSekolah = $pengaturanData->alamat_sekolah ?? 'Jl. Ipik Gandamanah No.63 Purwakarta';
                $kepalaSekolah = $pengaturanData->kepala_sekolah ?? 'Nama Kepala Sekolah';
                $nipKepala     = $pengaturanData->nip_kepala_sekolah ?? '-';
            @endphp

            <div class="kartu">
                <div class="kop">
                    <img src="{{ asset('images/sd.png') }}" class="kop-logo" alt="Logo" onerror="this.style.display='none'">
                    <div class="kop-text">
                        <div class="baris-1">PERPUSTAKAAN SEKOLAH</div>
                        <div class="baris-2">{{ strtoupper($namaSekolah) }}</div>
                        <div class="baris-3">{{ $alamatSekolah }}</div>
                    </div>
                </div>

                <div class="judul-kartu">KARTU PERPUSTAKAAN</div>

                <div class="body-kartu">
                    <!-- TANDA TANGAN KEPALA SEKOLAH (TERHUBUNG KE PENGATURAN) -->
                    <div class="ttd-section">
                        <div>Purwakarta, {{ date('d-m-Y') }}</div>
                        <div>Kepala Sekolah</div>
                        <div class="ttd-space"></div>
                        <div>
                            <div class="font-bold underline">{{ $kepalaSekolah }}</div>
                            <div>NIP. {{ $nipKepala }}</div>
                        </div>
                    </div>

                    <!-- DATA ANGGOTA SISWA -->
                    <div class="data-section">
                        <table class="data-table">
                            <tr>
                                <td class="col-label">No. Anggota</td>
                                <td class="col-titik">:</td>
                                <td class="col-value">{{ $a->nis }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Nama</td>
                                <td class="col-titik">:</td>
                                <td class="col-value">{{ $a->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Tempat Lahir</td>
                                <td class="col-titik">:</td>
                                <td class="col-value">{{ $a->tempat_lahir ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Tgl Lahir</td>
                                <td class="col-titik">:</td>
                                <td class="col-value">
                                    @if(isset($a->tanggal_lahir) && $a->tanggal_lahir)
                                        {{ \Carbon\Carbon::parse($a->tanggal_lahir)->format('d-m-Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="col-label">Jenis Kelamin</td>
                                <td class="col-titik">:</td>
                                <td class="col-value">{{ strtoupper($a->jenis_kelamin ?? '-') }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Alamat</td>
                                <td class="col-titik">:</td>
                                <td class="col-value" style="line-height: 1.1;">{{ $a->alamat ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
