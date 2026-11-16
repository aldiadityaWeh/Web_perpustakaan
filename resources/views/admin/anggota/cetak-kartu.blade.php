<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Anggota</title>

    <!-- Menggunakan Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
