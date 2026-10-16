<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu - {{ $anggota->nama_lengkap }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS Khusus untuk Print agar ukurannya pas KTP/Kartu Pelajar */
        @media print {
            @page { size: portrait; margin: 0; }
            body { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            .no-print { display: none !important; }
            .kartu-container { box-shadow: none !important; border: 1px solid #ccc !important; }
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center py-10 min-h-screen">

    <!-- Tombol Aksi (Hilang saat diprint) -->
    <div class="no-print mb-8 flex gap-4">
        <!-- TOMBOL KEMBALI DIPERBAIKI DI SINI -->
        <a href="{{ route('anggota.show', $anggota->id) }}" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl shadow-sm hover:bg-gray-50 flex items-center">
            &larr; Kembali
        </a>

        <button onclick="window.print()" class="px-6 py-2.5 bg-purple-600 text-white font-bold rounded-xl shadow-sm hover:bg-purple-700 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256"><path d="M224,96V200a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V96A16,16,0,0,1,48,80H72V40A16,16,0,0,1,88,24h80a16,16,0,0,1,16,16V80h24A16,16,0,0,1,224,96ZM88,40V80h80V40Zm120,56H48v96H64V168a16,16,0,0,1,16-16h96a16,16,0,0,1,16,16v24h16Zm-32,96V168H80v24ZM188,116a12,12,0,1,0-12-12A12,12,0,0,0,188,116Z"></path></svg>
            Print Kartu
        </button>
    </div>

    <!-- Ukuran Kartu Standar CR80 (KTP/ATM) -->
    <div class="kartu-container w-[340px] bg-white rounded-xl shadow-2xl overflow-hidden border border-gray-200 relative">

        <!-- Header Kartu -->
        <div class="bg-gradient-to-r from-purple-700 to-purple-500 p-4 text-center border-b-4 border-yellow-400">
            <h1 class="text-white font-black text-lg uppercase tracking-wider leading-none">Kartu Anggota</h1>
            <p class="text-purple-100 text-[10px] uppercase font-bold mt-1 tracking-widest">Perpustakaan Sekolah</p>
        </div>

        <!-- Body Kartu -->
        <div class="p-5 relative">
            <!-- Detail Data -->
            <div class="space-y-3 z-10 relative">
                <div>
                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Nama Lengkap</p>
                    <p class="text-sm font-black text-gray-800 leading-tight uppercase">{{ $anggota->nama_lengkap }}</p>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">NIS / NIP</p>
                        <p class="text-xs font-bold text-gray-800">{{ $anggota->nis }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Kelas/Status</p>
                        <p class="text-xs font-bold text-gray-800">{{ $anggota->kelas ?? 'Guru/Staf' }}</p>
                    </div>
                </div>
            </div>

            <!-- Area Identitas Tambahan (Pengganti Barcode) -->
            <div class="mt-4 flex flex-col items-center justify-center bg-purple-50 p-3 rounded-lg border border-purple-100 shadow-inner">
                <p class="text-[10px] text-purple-400 font-bold uppercase tracking-widest mb-0.5">ID / Sandi Kiosk</p>
                <p class="text-2xl font-black text-purple-700 tracking-widest">{{ $anggota->nis }}</p>
            </div>
        </div>

        <!-- Footer Kartu -->
        <div class="bg-gray-800 text-center py-1.5">
            <p class="text-[8px] text-gray-300">Harap bawa kartu ini setiap kali meminjam buku di Kiosk.</p>
        </div>

    </div>

</body>
</html>
