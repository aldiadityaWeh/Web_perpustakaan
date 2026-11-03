<x-admin-layout>
    <x-slot:title>
        Detail Buku - Sistem Perpustakaan
    </x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-slate-100 transition-colors">Informasi Detail Buku</h1>
            <p class="text-sm text-gray-500 dark:text-slate-400 mt-1 transition-colors">Melihat kelengkapan data inventaris buku</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('buku.index') }}" class="inline-flex items-center gap-2 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-300 px-4 py-2 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                <i class="ph ph-arrow-left text-lg"></i>
                Kembali
            </a>

            <!-- TOMBOL CETAK LABEL PDF (Membuka Tab Baru) -->
            <a href="{{ route('buku.cetak_label', $buku->id) }}" target="_blank" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-xl text-sm font-bold transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 cursor-pointer">
                <i class="ph ph-printer text-lg"></i>
                Cetak Label (PDF)
            </a>

            <!-- HANYA ADMIN YANG BISA MELIHAT TOMBOL EDIT -->
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('buku.edit', $buku->id) }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                    <i class="ph ph-pencil-simple text-lg"></i>
                    Edit Buku
                </a>
            @endif
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden max-w-5xl transition-colors">
        <div class="p-6 sm:p-8 flex flex-col md:flex-row gap-8">

            <!-- Bagian Kiri: Cover Buku & Stok -->
            <div class="w-full md:w-1/3 flex flex-col items-center">
                @if($buku->gambar_sampul)
                    <img src="{{ asset('storage/' . $buku->gambar_sampul) }}" alt="Sampul {{ $buku->judul }}" onerror="this.onerror=null;this.src='https://placehold.co/240x360/f3f4f6/a1a1aa?text=X'" class="w-full max-w-[240px] aspect-[2/3] object-cover rounded-xl shadow-md border border-gray-200 dark:border-slate-600 transition-colors">
                @else
                    <div class="w-full max-w-[240px] aspect-[2/3] bg-gray-50 dark:bg-slate-900 rounded-xl flex flex-col items-center justify-center text-gray-400 dark:text-slate-500 border-2 border-dashed border-gray-200 dark:border-slate-700 transition-colors">
                        <i class="ph ph-book-open text-5xl mb-2"></i>
                        <span class="text-sm font-medium">Tanpa Sampul</span>
                    </div>
                @endif

                <div class="mt-6 w-full max-w-[240px]">
                    <div class="bg-gray-50 dark:bg-slate-900/50 rounded-xl p-4 border border-gray-100 dark:border-slate-700 flex items-center justify-between transition-colors">
                        <span class="text-sm text-gray-500 dark:text-slate-400 font-medium">Stok Tersedia</span>
                        <span class="text-2xl font-black {{ $buku->stok > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $buku->stok }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-2/3 flex flex-col gap-6">

                <div class="border-b border-gray-100 dark:border-slate-700 pb-4 transition-colors">
                    <div class="inline-block px-3 py-1 bg-purple-100 dark:bg-purple-500/20 text-purple-700 dark:text-purple-400 text-[11px] font-bold rounded-lg uppercase tracking-wider mb-3 transition-colors border border-purple-200 dark:border-purple-500/30">
                        Kategori Utama: {{ $buku->kategori }}
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-800 dark:text-slate-100 leading-tight mb-2 transition-colors">{{ $buku->judul }}</h2>
                    <p class="text-lg text-gray-600 dark:text-slate-400 flex items-center gap-2 transition-colors">
                        <i class="ph ph-pen-nib text-purple-600 dark:text-purple-400"></i> {{ $buku->pengarang }}
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                    <div>
                        <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Nomor ISBN</p>
                        <p class="font-medium text-gray-800 dark:text-slate-200">{{ $buku->isbn ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Klasifikasi DDC</p>
                        <p class="font-medium text-gray-800 dark:text-slate-200">
                            <span class="bg-gray-100 dark:bg-slate-700 px-2 py-0.5 rounded border border-gray-200 dark:border-slate-600 font-mono text-sm shadow-sm transition-colors">
                                {{ $buku->ddc ?? $buku->kategori }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Penerbit</p>
                        <p class="font-medium text-gray-800 dark:text-slate-200">{{ $buku->penerbit ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Tahun Terbit</p>
                        <p class="font-medium text-gray-800 dark:text-slate-200">{{ $buku->tahun_terbit ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Lokasi Penyimpanan</p>
                        <p class="font-medium text-gray-800 dark:text-slate-200 flex items-center gap-1.5">
                            <i class="ph ph-books text-purple-600 dark:text-purple-400"></i> {{ $buku->rak ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Status Ketersediaan</p>
                        @if($buku->stok > 0)
                            <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-[10px] font-bold rounded-lg uppercase tracking-wider inline-block mt-1 transition-colors">Tersedia untuk dipinjam</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 text-[10px] font-bold rounded-lg uppercase tracking-wider inline-block mt-1 transition-colors">Sedang Kosong</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Terakhir Diperbarui</p>
                        <p class="font-medium text-gray-600 dark:text-slate-400 text-sm">{{ $buku->updated_at->format('d M Y - H:i') }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>
