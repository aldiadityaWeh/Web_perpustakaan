<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Label Buku - {{ $buku->judul }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS Print untuk ukuran Stiker Label (Misal Tom & Jerry 121: 38x75mm) */
        @media print {
            @page { size: portrait; margin: 0; }
            body { margin: 5mm; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important;}
            .no-print { display: none !important; }
            .label-stiker { border: 1px dashed #ccc !important; box-shadow: none !important;}
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center py-10 min-h-screen">

    <!-- Tombol Aksi -->
    <div class="no-print mb-8 flex gap-4">
        <!-- TOMBOL KEMBALI DIPERBAIKI DI SINI -->
        <a href="{{ route('buku.show', $buku->id) }}" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl shadow-sm hover:bg-gray-50 flex items-center">
            &larr; Kembali
        </a>

        <button onclick="window.print()" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl shadow-sm hover:bg-blue-700 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256"><path d="M224,96V200a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V96A16,16,0,0,1,48,80H72V40A16,16,0,0,1,88,24h80a16,16,0,0,1,16,16V80h24A16,16,0,0,1,224,96ZM88,40V80h80V40Zm120,56H48v96H64V168a16,16,0,0,1,16-16h96a16,16,0,0,1,16,16v24h16Zm-32,96V168H80v24ZM188,116a12,12,0,1,0-12-12A12,12,0,0,0,188,116Z"></path></svg>
            Print Stiker
        </button>
    </div>

    <p class="no-print text-sm text-gray-500 mb-4">Potongan garis putus-putus menggambarkan batas stiker label.</p>

    <!-- Label Stiker -->
    <div class="label-stiker w-[250px] bg-white rounded-sm shadow-md overflow-hidden border border-gray-300 flex flex-col">

        <!-- Header Warna Visual -->
        <div class="bg-blue-600 h-2 w-full"></div>

        <div class="p-3 pb-1 text-center">
            <!-- Judul Buku Pendek -->
            <p class="text-xs font-black text-gray-900 leading-tight line-clamp-2">{{ $buku->judul }}</p>
        </div>

        <div class="flex-1 px-3 py-2 flex flex-col items-center justify-center">
            <!-- Informasi Rak (Pengganti Barcode) -->
            <div class="w-full bg-blue-50 border-2 border-dashed border-blue-200 rounded-lg p-3 text-center flex flex-col items-center justify-center">
                <p class="text-[10px] text-blue-500 font-bold uppercase tracking-widest mb-1">Posisi Rak</p>
                <p class="text-4xl font-black text-blue-700 leading-none">{{ $buku->rak ?? 'A' }}</p>
            </div>
        </div>

        <!-- Footer Label: DDC & Nama Sekolah -->
        <div class="bg-gray-50 border-t border-gray-200 p-2 flex justify-between items-center">
            <div class="text-[9px] text-gray-500 uppercase font-bold tracking-widest">
                PERPUS SD
            </div>

            <!-- Label DDC -->
            <div class="bg-blue-600 text-white px-2 py-0.5 rounded text-xs font-black shadow-sm">
                DDC: {{ $buku->kategori }}
            </div>
        </div>

    </div>

</body>
</html>
