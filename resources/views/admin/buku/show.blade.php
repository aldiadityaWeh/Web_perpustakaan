<x-admin-layout>
    <x-slot:title>
        Detail Buku - Sistem Perpustakaan
    </x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Informasi Detail Buku</h1>
            <p class="text-sm text-gray-500 mt-1">Melihat kelengkapan data inventaris buku</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('buku.index') }}" class="inline-flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                <i class="ph ph-arrow-left text-lg"></i>
                Kembali
            </a>
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
</x-admin-layout>
