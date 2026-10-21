<x-admin-layout>
    <x-slot:title>
        Data Peminjaman - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 space-y-6">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-slate-100 transition-colors">Data Peminjaman</h1>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1 transition-colors">Kelola transaksi sirkulasi peminjaman buku</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- TOMBOL BUKA KIOSK -->
                <a href="{{ route('kiosk.index') }}" target="_blank"
                   class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-100 dark:hover:bg-blue-500/20 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-500/30 rounded-xl text-sm font-semibold transition-all shadow-sm">
                    <i class="ph ph-desktop text-lg font-bold"></i>
                    Buka Kiosk
                </a>

                <!-- TOMBOL MENUJU HALAMAN DENDA -->
                <a href="{{ route('denda.index') }}"
                   class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-500/30 rounded-xl text-sm font-semibold transition-all shadow-sm">
                    <i class="ph ph-receipt text-lg font-bold"></i>
                    Tagihan Denda
                </a>

                <!-- TOMBOL TAMBAH PEMINJAMAN -->
                <a href="{{ route('peminjaman.create') }}"
                   class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-purple-600 dark:bg-purple-500 hover:bg-purple-700 dark:hover:bg-purple-600 text-white border border-purple-600 dark:border-purple-500 rounded-xl text-sm font-semibold transition-all shadow-sm">
                    <i class="ph ph-plus-circle text-lg font-bold"></i>
                    Tambah Peminjaman
                </a>
            </div>
        </div>

        <div id="table-container" class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors flex-1 flex flex-col">

            <!-- Toolbar Pencarian Menyatu dengan Tabel -->
            <div class="p-4 border-b border-gray-100 dark:border-slate-700 flex flex-col sm:flex-row justify-between items-center gap-4 bg-gray-50/50 dark:bg-slate-800/50 transition-colors">
                <h2 class="text-sm font-bold text-gray-600 dark:text-slate-300 hidden sm:block">Daftar Sirkulasi Berjalan</h2>

                <form action="{{ route('peminjaman.index') }}" method="GET" class="flex w-full sm:w-auto min-w-[280px]">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ph ph-magnifying-glass text-gray-400 dark:text-slate-500 text-lg"></i>
                        </div>
                        <input type="text" id="searchInput" name="search" value="{{ request('search') }}" autocomplete="off" placeholder="Nama Siswa, NIS, atau Buku..."
                            class="pl-10 pr-3 w-full py-2 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 border-r-0 rounded-l-lg focus:ring-2 focus:ring-purple-600 outline-none transition-colors text-sm text-gray-700 dark:text-slate-200 placeholder-gray-400 dark:placeholder-slate-500">
                    </div>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-r-lg font-medium transition-colors shadow-sm focus:outline-none shrink-0 flex items-center justify-center gap-2 text-sm border border-purple-600 hover:border-purple-700">
                        <span>Cari</span>
                    </button>
                </form>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-500/10 p-4 flex items-center gap-3 text-emerald-700 dark:text-emerald-400 text-sm font-medium border-b border-emerald-100 dark:border-emerald-500/20 transition-colors">
                    <i class="ph ph-check-circle text-xl"></i> {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead class="bg-purple-50/50 dark:bg-slate-900/50 sticky top-0 z-10 border-b border-gray-200 dark:border-slate-700 transition-colors">
                        <tr class="text-gray-500 dark:text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-4 px-6 text-center w-16">No</th>
                            <th class="py-4 px-6">Peminjam</th>
                            <th class="py-4 px-6">Judul Buku</th>
                            <th class="py-4 px-6 text-center">Tgl Pinjam</th>
                            <th class="py-4 px-6 text-center">Batas Kembali</th>
                            <th class="py-4 px-6 text-center">Status</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-50 dark:divide-slate-700/50 transition-colors">
                        @forelse($peminjamans as $pinjam)
                        @php
                            $statusAkurat = strtolower(trim($pinjam->status_aktual));
                        @endphp
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition-colors text-sm group">

                            <td class="py-4 px-6 text-center font-medium text-gray-500 dark:text-slate-400">
                                {{ $loop->iteration + ($peminjamans->currentPage() - 1) * $peminjamans->perPage() }}
                            </td>

                            <td class="py-4 px-6">
                                <span class="font-bold text-gray-800 dark:text-slate-200 block">{{ $pinjam->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</span>
                                <span class="text-xs text-gray-400 dark:text-slate-500 font-mono mt-0.5 block">NIS: {{ $pinjam->anggota->nis ?? '-' }}</span>
                            </td>

                            <td class="py-4 px-6">
                                <span class="font-bold text-gray-800 dark:text-slate-200 block line-clamp-1" title="{{ $pinjam->buku->judul ?? 'Buku Dihapus' }}">{{ $pinjam->buku->judul ?? 'Buku Dihapus' }}</span>
                                <span class="text-xs text-gray-400 dark:text-slate-500 font-mono mt-0.5 block">ISBN: {{ $pinjam->buku->isbn ?? '-' }}</span>
                            </td>

                            <td class="py-4 px-6 text-center text-gray-600 dark:text-slate-300 font-medium">
                                {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') }}
                            </td>

                            <td class="py-4 px-6 text-center text-gray-600 dark:text-slate-300 font-medium">
                                {{ \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->format('d/m/Y') }}
                                @if($statusAkurat == 'terlambat')
                                    <span class="block text-red-600 dark:text-red-400 text-[10px] mt-1 font-bold">Telat {{ $pinjam->hari_terlambat }} Hari</span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-center">
                                <div class="flex flex-col items-center justify-center gap-1">
                                    @if($statusAkurat == 'dipinjam')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20 text-[10px] font-bold rounded-lg uppercase tracking-wider whitespace-nowrap transition-colors">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 dark:bg-amber-400"></span> Dipinjam
                                        </span>
                                    @elseif($statusAkurat == 'terlambat')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-500/20 text-[10px] font-bold rounded-lg uppercase tracking-wider whitespace-nowrap transition-colors">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 dark:bg-red-400 animate-pulse"></span> Terlambat
                                        </span>
                                        <span class="text-[10px] font-bold text-red-600 dark:text-red-400 tracking-wider">
                                            Denda: Rp {{ number_format($pinjam->denda_berjalan, 0, ',', '.') }}
                                        </span>
                                    @elseif($statusAkurat == 'dikembalikan' || $statusAkurat == 'sudah kembali')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20 text-[10px] font-bold rounded-lg uppercase tracking-wider whitespace-nowrap transition-colors">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400"></span> Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300 border border-gray-200 dark:border-slate-600 text-[10px] font-bold rounded-lg uppercase tracking-wider whitespace-nowrap transition-colors">
                                            {{ $pinjam->status_aktual }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center justify-center p-1 bg-white dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm gap-1 transition-colors">

                                    @if($statusAkurat == 'dipinjam' || $statusAkurat == 'terlambat')
                                        <a href="{{ route('peminjaman.validasi', $pinjam->id) }}" class="p-1.5 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 rounded-lg transition-colors flex items-center gap-1" title="Validasi Pengembalian">
                                            <i class="ph ph-check-square-offset text-lg"></i>
                                        </a>
                                        <div class="w-px h-4 bg-gray-200 dark:bg-slate-700"></div>
                                    @endif

                                    <a href="{{ route('peminjaman.show', $pinjam->id) }}" class="p-1.5 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 rounded-lg transition-colors flex items-center gap-1" title="Lihat Detail">
                                        <i class="ph ph-eye text-lg"></i>
                                    </a>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center -mt-4">
                                    <div class="w-24 h-24 rounded-full bg-purple-50 dark:bg-slate-700 border-8 border-white dark:border-slate-800 shadow-sm flex items-center justify-center mb-4 transition-colors">
                                        <i class="ph ph-handshake text-4xl text-purple-500 dark:text-slate-400 block leading-none"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-slate-200 mb-1">Belum Ada Transaksi</h3>
                                    <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mb-6">Pencarian tidak ditemukan atau data masih kosong.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="area-pagination" class="p-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 mt-auto transition-colors">
                <style>
                    /* Penyesuaian SVG agar pagination default Laravel terlihat sejajar di dark mode */
                    #area-pagination nav svg { width: 1.25rem; height: 1.25rem; display: inline-block; }
                    #area-pagination nav p { margin-top: 0; margin-bottom: 0; }
                    .dark #area-pagination nav span[aria-disabled="true"] span { background-color: #1e293b; border-color: #334155; color: #64748b; }
                    .dark #area-pagination nav span[aria-current="page"] span { background-color: #3b82f6; border-color: #3b82f6; color: white; }
                    .dark #area-pagination nav a { background-color: #1e293b; border-color: #334155; color: #cbd5e1; }
                    .dark #area-pagination nav a:hover { background-color: #334155; color: white; }
                </style>
                {{ $peminjamans->links() }}
            </div>
        </div>
    </div>

    <!-- LIBRARY SWEETALERT2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script Live Search Peminjaman -->
    <script src="{{ asset('js/search-peminjaman.js') }}"></script>
</x-admin-layout>
