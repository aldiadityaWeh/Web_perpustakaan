<x-admin-layout>
    <x-slot:title>
        Data Anggota - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 space-y-6">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-slate-100 transition-colors">Data Anggota</h1>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1 transition-colors">Kelola data siswa dan pustakawan yang terdaftar</p>

                <div class="mt-2 inline-block bg-blue-100 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 px-3 py-1.5 rounded-lg text-xs font-bold border border-blue-200 dark:border-blue-500/20 transition-colors">
                    <i class="ph ph-users mr-1"></i> Total Anggota Aktif: {{ \App\Models\Anggota::count() }} Orang
                </div>
            </div>

            <a href="{{ route('anggota.create') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-xl font-medium transition-all shadow-sm hover:shadow-md focus:outline-none shrink-0">
                <i class="ph ph-user-plus text-lg"></i>
                Tambah Anggota
            </a>
        </div>

        <!-- Target JS Table Container (Pencarian Menyatu) -->
        <div id="table-container" class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors flex-1 flex flex-col">

            <!-- Toolbar Tabel (Pencarian Diperkecil di Kanan) -->
            <div class="p-4 border-b border-gray-100 dark:border-slate-700 flex flex-col sm:flex-row justify-between items-center gap-4 bg-gray-50/50 dark:bg-slate-800/50 transition-colors">
                <h2 class="text-sm font-bold text-gray-600 dark:text-slate-300 hidden sm:block">Daftar Anggota Perpustakaan</h2>

                <form id="searchForm" data-url="{{ route('anggota.index') }}" action="{{ route('anggota.index') }}" method="GET" class="flex w-full sm:w-auto min-w-[280px]">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ph ph-magnifying-glass text-gray-400 dark:text-slate-500 text-lg"></i>
                        </div>
                        <input type="text" id="searchInput" name="search" value="{{ request('search') }}" autocomplete="off" placeholder="Ketik Nama, NIS, atau Kelas..."
                            class="pl-10 pr-3 w-full py-2 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 border-r-0 rounded-l-lg focus:ring-2 focus:ring-purple-600 outline-none transition-colors text-sm text-gray-700 dark:text-slate-200 placeholder-gray-400 dark:placeholder-slate-500">
                    </div>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-r-lg font-medium transition-colors shadow-sm focus:outline-none shrink-0 flex items-center justify-center gap-2 text-sm border border-purple-600 hover:border-purple-700">
                        <span id="searchLabel">Cari Data</span>
                        <i id="loadingSpinner" class="ph ph-spinner-gap animate-spin hidden text-base"></i>
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
                            <th class="py-4 px-6">Profil Siswa</th>
                            <th class="py-4 px-6">Kelas / Status</th>
                            <th class="py-4 px-6 text-center">Status</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-50 dark:divide-slate-700/50 transition-colors">
                        @forelse($anggotas as $anggota)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition-colors text-sm group">
                            <td class="py-4 px-6 text-gray-500 dark:text-slate-400 font-medium text-center">{{ $anggotas->firstItem() + $loop->index }}</td>

                            <!-- AREA QUICK VIEW: Profil Siswa -->
                            <td class="py-4 px-6" x-data="{ showQuickView: false }">
                                <div class="flex items-center gap-3">
                                    <!-- Foto Profil -->
                                    @if($anggota->foto)
                                        <img @click="showQuickView = true" src="{{ asset('storage/' . $anggota->foto) }}" alt="Foto" class="w-10 h-10 object-cover rounded-full shadow-sm border border-gray-200 dark:border-slate-600 shrink-0 cursor-pointer hover:opacity-80 transition-opacity" title="Lihat Profxil Cepat">
                                    @else
                                        <div @click="showQuickView = true" class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-500/20 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold border border-purple-200 dark:border-purple-500/30 shrink-0 cursor-pointer hover:opacity-80 transition-opacity" title="Lihat Profil Cepat">
                                            {{ strtoupper(substr($anggota->nama_lengkap, 0, 1)) }}
                                        </div>
                                    @endif

                                    <div>
                                        <!-- Nama Siswa sbg Tombol -->
                                        <button @click="showQuickView = true" type="button" class="font-bold text-gray-800 dark:text-slate-200 hover:text-purple-600 dark:hover:text-purple-400 block text-left transition-colors cursor-pointer text-sm mb-0.5">
                                            {{ $anggota->nama_lengkap }}
                                        </button>
                                        <span class="text-xs text-gray-400 dark:text-slate-500 font-mono">NIS: {{ $anggota->nis }}</span>
                                    </div>
                                </div>

                                <!-- MODAL POP-UP QUICK VIEW ANGGOTA -->
                                <div x-show="showQuickView" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 text-left">
                                    <!-- Backdrop -->
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
                                         class="relative bg-white dark:bg-slate-800 rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden flex flex-col border border-transparent dark:border-slate-700">

                                        <!-- Header Berwarna Modal -->
                                        <div class="h-24 bg-gradient-to-r from-purple-600 to-indigo-500 relative">
                                            <button @click="showQuickView = false" class="absolute top-4 right-4 text-white/80 hover:text-white transition-colors bg-black/20 hover:bg-black/40 p-1.5 rounded-full">
                                                <i class="ph ph-x text-lg"></i>
                                            </button>
                                        </div>

                                        <!-- Body Modal -->
                                        <div class="px-6 pb-6 pt-0 relative">
                                            <!-- Foto Menabrak Header -->
                                            <div class="flex justify-center -mt-12 mb-4">
                                                @if($anggota->foto)
                                                    <img src="{{ asset('storage/' . $anggota->foto) }}" class="w-24 h-24 object-cover rounded-full border-4 border-white dark:border-slate-800 shadow-md bg-white">
                                                @else
                                                    <div class="w-24 h-24 rounded-full border-4 border-white dark:border-slate-800 shadow-md bg-purple-100 dark:bg-slate-700 text-purple-600 dark:text-purple-400 flex items-center justify-center text-4xl font-bold">
                                                        {{ strtoupper(substr($anggota->nama_lengkap, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="text-center mb-6">
                                                <h2 class="text-2xl font-extrabold text-gray-900 dark:text-slate-100">{{ $anggota->nama_lengkap }}</h2>
                                                <p class="text-sm font-bold text-purple-600 dark:text-purple-400 mt-1">NIS: {{ $anggota->nis }}</p>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4 bg-gray-50 dark:bg-slate-700/50 p-4 rounded-2xl border border-gray-100 dark:border-slate-700/50">
                                                <div>
                                                    <p class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Kelas</p>
                                                    <p class="font-bold text-gray-800 dark:text-slate-200">{{ $anggota->kelas ?? 'Guru/Staf' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Status</p>
                                                    @if($anggota->status == 'Aktif')
                                                        <span class="text-emerald-600 dark:text-emerald-400 font-bold text-sm">Aktif</span>
                                                    @else
                                                        <span class="text-red-600 dark:text-red-400 font-bold text-sm">Tidak Aktif</span>
                                                    @endif
                                                </div>
                                                <div class="col-span-2">
                                                    <p class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Alamat Lengkap</p>
                                                    <p class="font-medium text-sm text-gray-700 dark:text-slate-300 leading-relaxed">{{ $anggota->alamat ?? 'Tidak ada data alamat.' }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Footer Modal -->
                                        <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 flex justify-between items-center rounded-b-3xl">
                                            <span class="text-xs text-gray-400 dark:text-slate-500">Terdaftar: {{ $anggota->created_at->format('d M Y') }}</span>
                                            <a href="{{ route('anggota.show', $anggota->id) }}" class="px-4 py-2 text-sm font-bold text-white bg-purple-600 hover:bg-purple-700 rounded-xl transition-colors shadow-sm flex items-center gap-2">
                                                Profil Penuh <i class="ph ph-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300 text-[11px] font-bold rounded-md whitespace-nowrap border border-gray-200 dark:border-slate-600 transition-colors">
                                    {{ $anggota->kelas ?? 'Guru/Staf' }}
                                </span>
                            </td>

                            <td class="py-4 px-6 text-center">
                                @if($anggota->status == 'Aktif')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20 text-[10px] font-bold rounded-lg uppercase tracking-wider whitespace-nowrap transition-colors">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-500/20 text-[10px] font-bold rounded-lg uppercase tracking-wider whitespace-nowrap transition-colors">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 dark:bg-red-400"></span> Tdk Aktif
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-center">
                                <!-- Action Group dengan Border -->
                                <div class="inline-flex items-center justify-center p-1 bg-white dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm gap-1">
                                    <a href="{{ route('anggota.show', $anggota->id) }}" class="p-1.5 text-teal-600 dark:text-teal-400 hover:bg-teal-50 dark:hover:bg-teal-500/10 rounded-lg transition-colors" title="Lihat Profil">
                                        <i class="ph ph-user-circle text-lg"></i>
                                    </a>

                                    <div class="w-px h-4 bg-gray-200 dark:bg-slate-700"></div>

                                    <a href="{{ route('anggota.edit', $anggota->id) }}" class="p-1.5 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 rounded-lg transition-colors" title="Edit Data">
                                        <i class="ph ph-pencil-simple text-lg"></i>
                                    </a>

                                    <div class="w-px h-4 bg-gray-200 dark:bg-slate-700"></div>

                                    <div x-data="{ showDeleteModal: false }" class="inline-block relative">
                                        <button @click="showDeleteModal = true" type="button" class="p-1.5 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors" title="Hapus Anggota">
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
                                                        <h3 class="font-bold text-gray-900 dark:text-slate-100 text-base">Hapus Anggota?</h3>
                                                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Data dan riwayatnya akan terhapus.</p>
                                                    </div>
                                                </div>
                                                <div class="flex justify-end gap-3 mt-6">
                                                    <button @click="showDeleteModal = false" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">Batal</button>
                                                    <form action="{{ route('anggota.destroy', $anggota->id) }}" method="POST">
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
                                    <div class="w-24 h-24 rounded-full bg-purple-50 dark:bg-slate-700 border-8 border-white dark:border-slate-800 shadow-sm flex items-center justify-center mb-4 transition-colors">
                                        <i class="ph ph-users text-4xl text-purple-500 dark:text-slate-400 block leading-none"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-slate-200 mb-1">Data Anggota Kosong</h3>
                                    <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mb-6">Pencarian tidak cocok atau belum ada data yang ditambahkan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- FITUR PAGINATION -->
            <div class="p-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 mt-auto transition-colors">
                @if ($anggotas->hasPages())
                    <div class="flex items-center justify-between w-full">
                        <div class="hidden sm:block text-sm text-gray-500 dark:text-slate-400">
                            Menampilkan <span class="font-bold text-gray-700 dark:text-slate-200">{{ $anggotas->currentPage() }}</span> dari <span class="font-bold text-gray-700 dark:text-slate-200">{{ $anggotas->lastPage() }}</span>
                        </div>

                        <nav class="relative z-0 inline-flex rounded-lg shadow-sm -space-x-px" aria-label="Pagination">
                            {{-- Tombol Panah Kiri --}}
                            @if ($anggotas->onFirstPage())
                                <span class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-gray-200 dark:border-slate-600 bg-gray-50 dark:bg-slate-700 text-gray-400 dark:text-slate-500 cursor-not-allowed transition-colors">
                                    <i class="ph ph-caret-left text-sm"></i>
                                </span>
                            @else
                                <a href="{{ $anggotas->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-600 dark:text-slate-300 hover:bg-purple-50 dark:hover:bg-slate-700 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                                    <i class="ph ph-caret-left text-sm"></i>
                                </a>
                            @endif

                            {{-- Logika 3 Kotak Angka --}}
                            @php
                                $start = max($anggotas->currentPage() - 1, 1);
                                $end = min($start + 2, $anggotas->lastPage());

                                if ($end - $start < 2) {
                                    $start = max($end - 2, 1);
                                }
                            @endphp

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $anggotas->currentPage())
                                    <span class="relative inline-flex items-center px-4 py-2 border border-purple-500 bg-purple-50 dark:bg-purple-500/20 text-sm font-bold text-purple-600 dark:text-purple-400 z-10 transition-colors">
                                        {{ $i }}
                                    </span>
                                @else
                                    <a href="{{ $anggotas->url($i) }}" class="relative inline-flex items-center px-4 py-2 border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-sm font-medium text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                        {{ $i }}
                                    </a>
                                @endif
                            @endfor

                            {{-- Tombol Panah Kanan --}}
                            @if ($anggotas->hasMorePages())
                                <a href="{{ $anggotas->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-2 rounded-r-lg border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-600 dark:text-slate-300 hover:bg-purple-50 dark:hover:bg-slate-700 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
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

    <!-- Memanggil Script Eksternal dari folder public/js -->
    <script src="{{ asset('js/search-anggota.js') }}"></script>
</x-admin-layout>
