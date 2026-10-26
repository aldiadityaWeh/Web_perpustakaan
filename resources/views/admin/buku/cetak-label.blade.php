<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Label Buku</title>

    <!-- Menggunakan Tailwind CDN agar tidak error Vite -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        @media print {
            @page {
                margin: 1cm;
            }
            body {
                /* Memaksa browser mencetak warna background */
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print {
                display: none !important;
            }
        }
        .label-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: flex-start;
        }
        .label-box {
            width: 4cm;
            height: 5cm;
            border: 1px dashed #4b5563; /* Garis potong */
            display: flex;
            flex-direction: column;
            page-break-inside: avoid;
            break-inside: avoid; /* Mencegah label terpotong di halaman baru */
            background-color: white;
        }
        .label-header {
            padding: 8px 4px;
            text-align: center;
            font-size: 11px;
            font-weight: bold;
            line-height: 1.3;
        }
        .label-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 16px;
            font-weight: bold;
            line-height: 1.6;
            color: #000;
        }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <!-- Header Tombol Print (Sembunyi saat dicetak) -->
    <div class="max-w-6xl mx-auto mb-6 flex flex-col sm:flex-row justify-between items-center gap-4 no-print">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Preview Label Punggung Buku</h2>
            <p class="text-gray-500 text-sm">Menampilkan <b>{{ count($buku) }}</b> label. Warna otomatis menyesuaikan kategori DDC (000-900).</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.close()" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-5 py-2.5 rounded-lg font-bold transition-all shadow-sm">
                Batal
            </button>
            <button onclick="window.print()" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-lg font-bold flex items-center gap-2 shadow-md transition-all">
                <i class="ph ph-printer text-xl"></i> Print Stiker
            </button>
        </div>
    </div>

    <!-- Kertas Print -->
    <div class="max-w-6xl mx-auto label-container">
        @foreach($buku as $b)
            @php
                // MENAMPILKAN ANGKA DDC SPESIFIK JIKA ADA, JIKA KOSONG GUNAKAN KATEGORI UTAMA
                $kodeDdcPrint = $b->ddc ?: ($b->kategori ?? '000');

                // WARNA BACKGROUND SELALU DIAMBIL DARI KATEGORI UTAMA (Bukan DDC Spesifik)
                $kategoriUtama = $b->kategori ?? '000';
                $awalan = substr($kategoriUtama, 0, 1);

                // Warna diekstrak persis dari file "WARNA LABEL PERKELAS.xlsx"
                $warnaBg = match($awalan) {
                    '0' => '#FFFF00', // Kuning
                    '1' => '#0000FF', // Biru Tua
                    '2' => '#76E3FF', // Biru Muda
                    '3' => '#FFFFFF', // Putih
                    '4' => '#FF0000', // Merah
                    '5' => '#D490BD', // Pink
                    '6' => '#975CCB', // Ungu
                    '7' => '#7CEB99', // Hijau Muda
                    '8' => '#E50000', // Merah Gelap
                    '9' => '#00BFBF', // Tosca / Cyan
                    default => '#FFFFFF'
                };

                // Teks kontras: Background gelap teks putih, background terang teks hitam
                $warnaTeks = in_array($awalan, ['1', '4', '6', '8', '9']) ? '#FFFFFF' : '#000000';

                // Jika kelas 300 (Putih), tambahkan garis bawah agar tidak menyatu dengan warna kertas
                $borderBottom = $awalan == '3' ? 'border-bottom: 2px solid #000;' : '';

                // Logika Kode Buku (Call Number)
                $kodePenulis = strtoupper(substr($b->pengarang ?? 'NN', 0, 3));
                $kodeJudul = strtolower(substr($b->judul ?? 'b', 0, 1));

                // Ambil Nama Sekolah dari database Pengaturan
                $namaSekolah = $pengaturan->nama_sekolah ?? 'UPTD SDN 6 CISEUREUH';
            @endphp

            <div class="label-box">
                <!-- Header Kotak Warna -->
                <div class="label-header" style="background-color: {{ $warnaBg }}; color: {{ $warnaTeks }}; {{ $borderBottom }}">
                    <div>PERPUSTAKAAN</div>
                    <div>{{ strtoupper($namaSekolah) }}</div>
                </div>

                <!-- Body Label Nomor Klasifikasi -->
                <div class="label-body">
                    <div>{{ $kodeDdcPrint }}</div>
                    <div>{{ $kodePenulis }}</div>
                    <div>{{ $kodeJudul }}</div>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
