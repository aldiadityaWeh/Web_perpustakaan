<x-admin-layout>
    <x-slot:title>
        Data Buku - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 space-y-6">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-slate-100 transition-colors">Data Buku</h1>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1 transition-colors">Kelola inventaris koleksi buku perpustakaan</p>

                <div class="mt-2 inline-block bg-blue-100 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 px-3 py-1.5 rounded-lg text-xs font-bold border border-blue-200 dark:border-blue-500/20 transition-colors">
                    <i class="ph ph-database mr-1"></i> Total di Database: {{ \App\Models\Buku::count() }} Data
                </div>
            </div>

            <a href="{{ route('buku.create') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-xl font-medium transition-all shadow-sm hover:shadow-md focus:outline-none shrink-0">
                <i class="ph ph-plus text-lg"></i>
                Tambah Buku
            </a>
        </div>

        <!-- Target JS Table Container Buku (Pencarian Sudah Masuk ke Sini) -->
        <div id="table-container-buku" class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors flex-1 flex flex-col">

            <!-- Toolbar Tabel (Pencarian Diperkecil di Kanan) -->
            <div class="p-4 border-b border-gray-100 dark:border-slate-700 flex flex-col sm:flex-row justify-between items-center gap-4 bg-gray-50/50 dark:bg-slate-800/50 transition-colors">
                <h2 class="text-sm font-bold text-gray-600 dark:text-slate-300 hidden sm:block">Daftar Inventaris Buku</h2>

                <form id="searchFormBuku" data-url="{{ route('buku.index') }}" action="{{ route('buku.index') }}" method="GET" class="flex w-full sm:w-auto min-w-[280px]">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ph ph-magnifying-glass text-gray-400 dark:text-slate-500 text-lg"></i>
                        </div>
                        <input type="text" id="searchInputBuku" name="search" value="{{ request('search') }}" autocomplete="off" placeholder="Ketik pencarian..."
                            class="pl-10 pr-3 w-full py-2 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 border-r-0 rounded-l-lg focus:ring-2 focus:ring-purple-600 outline-none transition-colors text-sm text-gray-700 dark:text-slate-200 placeholder-gray-400 dark:placeholder-slate-500">
                    </div>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-r-lg font-medium transition-colors shadow-sm focus:outline-none shrink-0 flex items-center justify-center gap-2 text-sm border border-purple-600 hover:border-purple-700">
                        <span id="searchLabelBuku">Cari</span>
                        <i id="loadingSpinnerBuku" class="ph ph-spinner-gap animate-spin hidden text-base"></i>
                    </button>
                </form>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-500/10 border-b border-emerald-100 dark:border-emerald-500/20 p-4 flex items-center gap-3 text-emerald-700 dark:text-emerald-400 text-sm font-medium transition-colors">
                    <i class="ph ph-check-circle text-xl"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead class="bg-purple-50 dark:bg-slate-900/50 sticky top-0 z-10 border-b border-gray-200 dark:border-slate-700 transition-colors">
                        <tr class="text-gray-500 dark:text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-4 px-6 w-16 text-center">No</th>
                            <th class="py-4 px-6">Judul Buku</th>
                            <th class="py-4 px-6">Kategori</th>
                            <th class="py-4 px-6">Stok</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                  <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-50 dark:divide-slate-700/50 transition-colors">
                        @forelse($bukus as $buku)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition-colors text-sm group">
                            <td class="py-4 px-6 text-gray-500 dark:text-slate-400 font-medium text-center">{{ $bukus->firstItem() + $loop->index }}</td>

                            <!-- AREA QUICK VIEW: Ditambahkan x-data di sini -->
                            <td class="py-4 px-6" x-data="{ showQuickView: false }">
                                <div class="flex items-center gap-3">
                                    <!-- FITUR FOTO SAMPUL BUKU (Sekarang bisa diklik) -->
                                    @if($buku->gambar_sampul)
                                        <img @click="showQuickView = true" src="{{ asset('storage/' . $buku->gambar_sampul) }}" alt="Sampul" onerror="this.onerror=null;this.src='https://placehold.co/40x56/f3f4f6/a1a1aa?text=X'" class="w-10 h-14 object-cover rounded-lg shadow-sm border border-gray-200 dark:border-slate-600 shrink-0 cursor-pointer hover:opacity-80 transition-opacity" title="Lihat Detail Cepat">
                                    @else
                                        <div @click="showQuickView = true" class="w-10 h-14 rounded-lg bg-blue-50 dark:bg-blue-500/10 text-blue-500 dark:text-blue-400 flex items-center justify-center font-bold border border-blue-100 dark:border-blue-500/20 shrink-0 cursor-pointer hover:opacity-80 transition-opacity" title="Lihat Detail Cepat">
                                            <i class="ph ph-image text-xl"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <!-- JUDUL BUKU SEBAGAI TOMBOL -->
                                        <button @click="showQuickView = true" type="button" class="font-bold text-gray-800 dark:text-slate-200 hover:text-purple-600 dark:hover:text-purple-400 block text-left transition-colors cursor-pointer text-sm mb-0.5">
                                            {{ $buku->judul }}
                                        </button>
                                        <span class="text-xs text-gray-400 dark:text-slate-500">Pengarang: {{ $buku->pengarang }}</span>
                                    </div>
                                </div>

                                <!-- MODAL POP-UP QUICK VIEW -->
                                <div x-show="showQuickView" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 text-left">
                                    <!-- Backdrop Gelap -->
                                    <div x-show="showQuickView" x-transition.opacity class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showQuickView = false"></div>

                                    <!-- Konten Modal -->
                                    <div x-show="showQuickView"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                         x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                                         @click.away="showQuickView = false"
                                         class="relative bg-white dark:bg-slate-800 rounded-3xl w-full max-w-2xl shadow-2xl overflow-hidden flex flex-col border border-transparent dark:border-slate-700 max-h-[90vh]">

                                        <!-- Header Modal -->
                                        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-800/50">
                                            <h3 class="font-bold text-gray-800 dark:text-slate-100 flex items-center gap-2">
                                                <i class="ph ph-info text-purple-600 dark:text-purple-400 text-xl"></i> Detail Cepat
                                            </h3>
                                            <button @click="showQuickView = false" class="text-gray-400 hover:text-red-500 transition-colors p-1 rounded-lg hover:bg-red-50 dark:hover:bg-red-500/10">
                                                <i class="ph ph-x text-xl"></i>
                                            </button>
                                        </div>

                                        <!-- Body Modal -->
                                        <div class="p-6 overflow-y-auto flex flex-col sm:flex-row gap-6">
                                            <!-- Sampul Kiri -->
                                            <div class="w-full sm:w-1/3 flex flex-col items-center shrink-0">
                                                @if($buku->gambar_sampul)
                                                    <img src="{{ asset('storage/' . $buku->gambar_sampul) }}" alt="Sampul" class="w-full aspect-[2/3] object-cover rounded-xl shadow-md border border-gray-200 dark:border-slate-600">
                                                @else
                                                    <div class="w-full aspect-[2/3] bg-gray-50 dark:bg-slate-700 rounded-xl flex flex-col items-center justify-center text-gray-400 border-2 border-dashed border-gray-200 dark:border-slate-600">
                                                        <i class="ph ph-book-open text-5xl mb-2"></i>
                                                        <span class="text-xs">Tanpa Sampul</span>
                                                    </div>
                                                @endif

                                                <div class="mt-4 w-full bg-gray-50 dark:bg-slate-700/50 border border-gray-100 dark:border-slate-600 rounded-xl p-3 text-center">
                                                    <p class="text-[10px] font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest mb-1">Stok Saat Ini</p>
                                                    <p class="text-2xl font-black {{ $buku->stok > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">{{ $buku->stok }} <span class="text-sm font-normal">Pcs</span></p>
                                                </div>
                                            </div>

                                            <!-- Data Kanan -->
                                            <div class="flex-1 space-y-4">
                                                <div>
                                                    <span class="px-2.5 py-1 bg-purple-100 dark:bg-purple-500/20 text-purple-700 dark:text-purple-400 text-[10px] font-bold rounded-md uppercase tracking-wider mb-2 inline-block border border-purple-200 dark:border-purple-500/30">
                                                        DDC: {{ $buku->kategori }}
                                                    </span>
                                                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-slate-100 leading-tight">{{ $buku->judul }}</h2>
                                                    <p class="text-sm text-gray-600 dark:text-slate-400 mt-1"><i class="ph ph-pen-nib"></i> {{ $buku->pengarang }}</p>
                                                </div>

                                                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-100 dark:border-slate-700">
                                                    <div>
                                                        <p class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">ISBN</p>
                                                        <p class="text-sm font-bold text-gray-800 dark:text-slate-200">{{ $buku->isbn ?? '-' }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">Penerbit</p>
                                                        <p class="text-sm font-bold text-gray-800 dark:text-slate-200">{{ $buku->penerbit ?? '-' }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">Tahun</p>
                                                        <p class="text-sm font-bold text-gray-800 dark:text-slate-200">{{ $buku->tahun_terbit ?? '-' }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">Rak</p>
                                                        <p class="text-sm font-bold text-gray-800 dark:text-slate-200 flex items-center gap-1"><i class="ph ph-books text-purple-500"></i> {{ $buku->rak ?? '-' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 px-6 text-gray-600 dark:text-slate-300">
                                @php
                                    $kategoriLabel = [
                                        '000' => 'Komputer & Informasi', '100' => 'Filsafat & Psikologi', '200' => 'Agama',
                                        '300' => 'Ilmu Sosial', '400' => 'Bahasa', '500' => 'Sains & Matematika',
                                        '600' => 'Teknologi Terapan', '700' => 'Seni & Olahraga', '800' => 'Kesusastraan',
                                        '900' => 'Sejarah & Geografi',
                                    ];
                                    $namaKategori = $kategoriLabel[$buku->kategori] ?? ucfirst($buku->kategori);
                                @endphp
                                <span class="px-2.5 py-1 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300 text-[11px] font-bold rounded-md whitespace-nowrap border border-gray-200 dark:border-slate-600 transition-colors">
                                    {{ $namaKategori }}
                                </span>
                            </td>
                           <td class="py-4 px-6 font-bold text-gray-800 dark:text-slate-200">
                                {{ $buku->stok }} <span class="text-xs font-normal text-gray-400 dark:text-slate-500">Pcs</span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <!-- DESAIN BARU: Action Group dengan Border & Pemisah -->
                                <div class="inline-flex items-center justify-center p-1 bg-white dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm gap-1">
                                    <a href="{{ route('buku.show', $buku->id) }}" class="p-1.5 text-teal-600 dark:text-teal-400 hover:bg-teal-50 dark:hover:bg-teal-500/10 rounded-lg transition-colors" title="Lihat Detail">
                                        <i class="ph ph-eye text-lg"></i>
                                    </a>

                                    <!-- Garis Pemisah Tipis -->
                                    <div class="w-px h-4 bg-gray-200 dark:bg-slate-700"></div>

                                    <a href="{{ route('buku.edit', $buku->id) }}" class="p-1.5 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 rounded-lg transition-colors" title="Edit">
                                        <i class="ph ph-pencil-simple text-lg"></i>
                                    </a>

                                    <!-- Garis Pemisah Tipis -->
                                    <div class="w-px h-4 bg-gray-200 dark:bg-slate-700"></div>

                                    <div x-data="{ showDeleteModal: false }" class="inline-block relative">
                                        <button @click="showDeleteModal = true" type="button" class="p-1.5 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors" title="Hapus">
                                            <i class="ph ph-trash text-lg"></i>
                                        </button>

                                        <!-- Modal Hapus -->
                                        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[99] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 text-left">
                                            <div @click.away="showDeleteModal = false" class="bg-white dark:bg-slate-800 rounded-2xl p-6 w-full max-w-sm shadow-xl transform transition-all border border-transparent dark:border-slate-700">
                                                <div class="flex items-center gap-4 mb-4">
                                                    <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400 flex items-center justify-center text-xl shrink-0">
                                                        <i class="ph ph-warning-circle"></i>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-bold text-gray-900 dark:text-slate-100 text-base">Hapus Buku?</h3>
                                                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Data buku ini akan dihapus permanen.</p>
                                                    </div>
                                                </div>
                                                <div class="flex justify-end gap-3 mt-6">
                                                    <button @click="showDeleteModal = false" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">Batal</button>
                                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 dark:bg-red-500 rounded-xl hover:bg-red-700 dark:hover:bg-red-600 transition-colors">Ya, Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center -mt-4">
                                    <div class="w-24 h-24 rounded-full bg-blue-50 dark:bg-slate-700 border-8 border-white dark:border-slate-800 shadow-sm flex items-center justify-center mb-4 transition-colors">
                                        <i class="ph ph-book text-4xl text-blue-500 dark:text-slate-400 block leading-none"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-slate-200 mb-1">Data Buku Tidak Ditemukan</h3>
                                    <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mb-6">Pencarian tidak cocok dengan buku manapun.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- FITUR PAGINATION -->
            <div class="p-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 mt-auto transition-colors">
                @if ($bukus->hasPages())
                    <div class="flex items-center justify-between w-full">
                        <div class="hidden sm:block text-sm text-gray-500 dark:text-slate-400">
                            Menampilkan <span class="font-bold text-gray-700 dark:text-slate-200">{{ $bukus->currentPage() }}</span> dari <span class="font-bold text-gray-700 dark:text-slate-200">{{ $bukus->lastPage() }}</span>
                        </div>

                        <nav class="relative z-0 inline-flex rounded-lg shadow-sm -space-x-px" aria-label="Pagination">
                            {{-- Tombol Panah Kiri --}}
                            @if ($bukus->onFirstPage())
                                <span class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-gray-200 dark:border-slate-600 bg-gray-50 dark:bg-slate-700 text-gray-400 dark:text-slate-500 cursor-not-allowed transition-colors">
                                    <i class="ph ph-caret-left text-sm"></i>
                                </span>
                            @else
                                <a href="{{ $bukus->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-600 dark:text-slate-300 hover:bg-purple-50 dark:hover:bg-slate-700 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                                    <i class="ph ph-caret-left text-sm"></i>
                                </a>
                            @endif

                            {{-- Logika 3 Kotak Angka yang Sudah Diperbaiki --}}
                            @php
                                $start = max($bukus->currentPage() - 1, 1);
                                $end = min($start + 2, $bukus->lastPage());
                                if ($end - $start < 2) {
                                    $start = max($end - 2, 1);
                                }
                            @endphp

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $bukus->currentPage())
                                    <span class="relative inline-flex items-center px-4 py-2 border border-purple-500 bg-purple-50 dark:bg-purple-500/20 text-sm font-bold text-purple-600 dark:text-purple-400 z-10 transition-colors">
                                        {{ $i }}
                                    </span>
                                @else
                                    <a href="{{ $bukus->url($i) }}" class="relative inline-flex items-center px-4 py-2 border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-sm font-medium text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                        {{ $i }}
                                    </a>
                                @endif
                            @endfor

                            {{-- Tombol Panah Kanan --}}
                            @if ($bukus->hasMorePages())
                                <a href="{{ $bukus->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-2 rounded-r-lg border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-600 dark:text-slate-300 hover:bg-purple-50 dark:hover:bg-slate-700 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                                    <i class="ph ph-caret-right text-sm"></i>
                                </a>
                            @else
                                <span class="relative inline-flex items-center px-3 py-2 rounded-r-lg border border-gray-200 dark:border-slate-600 bg-gray-50 dark:bg-slate-700 text-gray-400 dark:text-slate-500 cursor-not-allowed transition-colors">
                                    <i class="ph ph-caret-right text-sm"></i>
                                </span>
                            @endif
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Memanggil Script Eksternal Live Search Buku -->
    <script src="{{ asset('js/search-buku.js') }}"></script>
</x-admin-layout>
