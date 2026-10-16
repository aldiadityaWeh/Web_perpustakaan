<x-admin-layout>
    <x-slot:title>
        Detail Buku - Sistem Perpustakaan
    </x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div>
            <h1 class="text-2xl font-bold text-gray-800">Informasi Detail Buku</h1>
            <p class="text-sm text-gray-500 mt-1">Melihat kelengkapan data inventaris buku</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('buku.index') }}" class="inline-flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                <i class="ph ph-arrow-left text-lg"></i>
                Kembali
            </a>

            <!-- TOMBOL DOWNLOAD DIPERBARUI (MENGIRIMKAN NAMA FILE KE JS) -->
            <button type="button" onclick="downloadAsImage('label-buku-design', 'Label_Buku_{{ $buku->isbn ?? $buku->id }}.png')" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl text-sm font-bold transition-colors shadow-sm focus:outline-none cursor-pointer">
                <i class="ph ph-download-simple text-lg"></i>
                Download Label
            </button>

            <a href="{{ route('buku.edit', $buku->id) }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="ph ph-pencil-simple text-lg"></i>
                Edit Buku
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-5xl">
        <div class="p-6 sm:p-8 flex flex-col md:flex-row gap-8">

            <!-- Bagian Kiri: Cover Buku -->
            <div class="w-full md:w-1/3 flex flex-col items-center">
                @if($buku->gambar_sampul)
                    <img src="{{ asset('storage/' . $buku->gambar_sampul) }}" alt="Sampul {{ $buku->judul }}" class="w-full max-w-[240px] aspect-[2/3] object-cover rounded-xl shadow-md border border-gray-200">
                @else
                    <div class="w-full max-w-[240px] aspect-[2/3] bg-gray-50 rounded-xl flex flex-col items-center justify-center text-gray-400 border-2 border-dashed border-gray-200">
                        <i class="ph ph-book-open text-5xl mb-2"></i>
                        <span class="text-sm font-medium">Tanpa Sampul</span>
                    </div>
                @endif

                <div class="mt-6 w-full max-w-[240px]">
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 flex items-center justify-between">
                        <span class="text-sm text-gray-500 font-medium">Stok Tersedia</span>
                        <span class="text-2xl font-black {{ $buku->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $buku->stok }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-2/3 flex flex-col gap-6">

                <div class="border-b border-gray-100 pb-4">
                    <div class="inline-block px-3 py-1 bg-purple-100 text-purple-700 text-[11px] font-bold rounded-lg uppercase tracking-wider mb-3">
                        {{ ucfirst($buku->kategori) }}
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-800 leading-tight mb-2">{{ $buku->judul }}</h2>
                    <p class="text-lg text-gray-600 flex items-center gap-2">
                        <i class="ph ph-pen-nib text-purple-600"></i> {{ $buku->pengarang }}
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nomor ISBN</p>
                        <p class="font-medium text-gray-800">{{ $buku->isbn }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Penerbit</p>
                        <p class="font-medium text-gray-800">{{ $buku->penerbit }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tahun Terbit</p>
                        <p class="font-medium text-gray-800">{{ $buku->tahun_terbit }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Lokasi Penyimpanan</p>
                        <p class="font-medium text-gray-800 flex items-center gap-1.5">
                            <i class="ph ph-books text-purple-600"></i> {{ $buku->rak }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Status Ketersediaan</p>
                        @if($buku->stok > 0)
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-lg uppercase tracking-wider inline-block mt-1">Tersedia untuk dipinjam</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded-lg uppercase tracking-wider inline-block mt-1">Sedang Kosong</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Terakhir Diperbarui</p>
                        <p class="font-medium text-gray-600 text-sm">{{ $buku->updated_at->format('d M Y - H:i') }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- ========================================== -->
    <!-- AREA TERSEMBUNYI UNTUK RENDER DOWNLOAD PNG -->
    <!-- ========================================== -->
    <div style="position: absolute; left: -9999px; top: 0; z-index: -10;">
        <div id="label-buku-design" class="w-[250px] bg-white rounded-sm overflow-hidden border border-gray-300 flex flex-col">
            <!-- Header Warna Visual -->
            <div class="bg-purple-600 h-2 w-full"></div>

            <div class="p-3 pb-1 text-center bg-white">
                <p class="text-xs font-black text-gray-900 leading-tight line-clamp-2">{{ $buku->judul }}</p>
            </div>

            <div class="flex-1 px-3 py-2 flex flex-col items-center justify-center bg-white">
                <!-- Informasi Rak (Pengganti Barcode) -->
                <div class="w-full bg-purple-50 border-2 border-dashed border-purple-200 rounded-lg p-3 text-center flex flex-col items-center justify-center">
                    <p class="text-[10px] text-purple-500 font-bold uppercase tracking-widest mb-1">Posisi Rak</p>
                    <p class="text-4xl font-black text-purple-700 leading-none">{{ $buku->rak ?? 'A' }}</p>
                </div>
            </div>

            <!-- Footer Label: DDC & Nama Sekolah -->
            <div class="bg-gray-50 border-t border-gray-200 p-2 flex justify-between items-center">
                <div class="text-[9px] text-gray-500 uppercase font-bold tracking-widest">
                    PERPUS SEKOLAH
                </div>
                <!-- Label DDC -->
                <div class="bg-purple-600 text-white px-2 py-0.5 rounded text-xs font-black shadow-sm">
                    DDC: {{ $buku->kategori }}
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT UNTUK DOWNLOAD MENJADI GAMBAR PNG -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="{{ asset('js/cetak-gambar.js') }}"></script>
</x-admin-layout>
