<x-admin-layout>
    <x-slot:title>
        Riwayat Pengembalian - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 space-y-6">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-slate-100 transition-colors">Riwayat Pengembalian</h1>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1 transition-colors">Daftar buku yang telah selesai dikembalikan</p>
            </div>

            <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center gap-2 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-300 border border-gray-200 dark:border-slate-600 px-5 py-2.5 rounded-xl font-medium transition-colors shadow-sm focus:outline-none shrink-0">
                <i class="ph ph-handshake text-lg"></i>
                Kembali ke Peminjaman
            </a>
        </div>

        <!-- WADAH TABEL (Pencarian Menyatu di Sini) -->
        <div id="table-container" class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors flex-1 flex flex-col">

            <!-- Toolbar Tabel -->
            <div class="p-4 border-b border-gray-100 dark:border-slate-700 flex flex-col sm:flex-row justify-between items-center gap-4 bg-gray-50/50 dark:bg-slate-800/50 transition-colors">
                <h2 class="text-sm font-bold text-gray-600 dark:text-slate-300 hidden sm:block">Daftar Riwayat Selesai</h2>

                <form action="{{ route('pengembalian.index') }}" method="GET" class="flex w-full sm:w-auto min-w-[280px]">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ph ph-magnifying-glass text-gray-400 dark:text-slate-500 text-lg"></i>
                        </div>
                        <input type="text" id="searchInput" name="search" value="{{ request('search') }}" autocomplete="off" placeholder="Ketik Nama Siswa, NIS, atau Buku..."
                            class="pl-10 pr-3 w-full py-2 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 border-r-0 rounded-l-lg focus:ring-2 focus:ring-purple-600 outline-none transition-colors text-sm text-gray-700 dark:text-slate-200 placeholder-gray-400 dark:placeholder-slate-500">
                    </div>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-r-lg font-medium transition-colors shadow-sm focus:outline-none shrink-0 flex items-center justify-center gap-2 text-sm border border-purple-600 hover:border-purple-700">
                        <span>Cari Data</span>
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead class="bg-purple-50/50 dark:bg-slate-900/50 sticky top-0 z-10 border-b border-gray-200 dark:border-slate-700 transition-colors">
                        <tr class="text-gray-500 dark:text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-4 px-6 text-center w-16">No</th>
                            <th class="py-4 px-6">Buku & Peminjam</th>
                            <th class="py-4 px-6 text-center">Tgl Dikembalikan</th>
                            <th class="py-4 px-6 text-center">Denda (Rp)</th>
                            <th class="py-4 px-6">Kondisi / Catatan</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-50 dark:divide-slate-700/50 transition-colors">
                        @forelse($pengembalians as $kembali)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition-colors text-sm group">

                            <!-- Kolom Nomor Urut -->
                            <td class="py-4 px-6 text-center font-medium text-gray-500 dark:text-slate-400">
                                {{ $loop->iteration + ($pengembalians->currentPage() - 1) * $pengembalians->perPage() }}
                            </td>

                            <!-- Kolom Buku & Peminjam -->
                            <td class="py-4 px-6">
                                <span class="font-bold text-gray-800 dark:text-slate-200 block line-clamp-1" title="{{ $kembali->buku->judul ?? 'Buku Dihapus' }}">{{ $kembali->buku->judul ?? 'Buku Dihapus' }}</span>
                                <span class="text-xs text-gray-500 dark:text-slate-400 mt-1 block">Peminjam: <span class="font-bold text-gray-700 dark:text-slate-300">{{ $kembali->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</span></span>
                            </td>

                            <!-- Kolom Tanggal Dikembalikan -->
                            <td class="py-4 px-6 text-center text-gray-600 dark:text-slate-300 font-medium">
                                {{ \Carbon\Carbon::parse($kembali->updated_at)->format('d M Y') }}
                                <span class="block text-[10px] text-gray-400 dark:text-slate-500 mt-0.5">{{ \Carbon\Carbon::parse($kembali->updated_at)->format('H:i') }} WIB</span>
                            </td>

                            <!-- Kolom Denda -->
                            <td class="py-4 px-6 text-center">
                                @if($kembali->denda > 0)
                                    <span class="inline-flex items-center px-2.5 py-1 bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-500/20 text-[11px] font-bold rounded-lg tracking-wider transition-colors">
                                        Rp {{ number_format($kembali->denda, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-[11px] font-medium text-gray-400 dark:text-slate-500">Gratis / Rp 0</span>
                                @endif
                            </td>

                            <!-- Kolom Catatan -->
                            <td class="py-4 px-6">
                                <div class="max-w-[200px] truncate text-xs text-gray-600 dark:text-slate-300 transition-colors" title="{{ $kembali->catatan ?? 'Kondisi Aman' }}">
                                    @if(str_contains($kembali->catatan, 'Kondisi: Rusak') || str_contains($kembali->catatan, 'Hilang'))
                                        <span class="text-red-600 dark:text-red-400 font-bold flex items-center gap-1.5"><i class="ph ph-warning"></i> {{ $kembali->catatan }}</span>
                                    @else
                                        {{ $kembali->catatan ?? 'Kondisi Aman' }}
                                    @endif
                                </div>
                            </td>

                            <!-- Kolom Aksi -->
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center justify-center p-1 bg-white dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm gap-1 transition-colors">
                                    <a href="{{ route('peminjaman.show', $kembali->id) }}" class="p-1.5 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 rounded-lg transition-colors flex items-center gap-1.5 px-2" title="Lihat Detail Transaksi">
                                        <i class="ph ph-eye text-lg"></i> <span class="text-xs font-bold">Detail</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center -mt-4">
                                    <div class="w-24 h-24 rounded-full bg-purple-50 dark:bg-slate-700 border-8 border-white dark:border-slate-800 shadow-sm flex items-center justify-center mb-4 transition-colors">
                                        <i class="ph ph-clock-counter-clockwise text-4xl text-purple-500 dark:text-slate-400 block leading-none"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-slate-200 mb-1">Belum Ada Riwayat</h3>
                                    <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mb-6">Pencarian tidak ditemukan atau belum ada buku yang dikembalikan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div id="area-pagination" class="p-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 mt-auto transition-colors">
                <style>
                    /* Penyesuaian SVG agar pagination terlihat sejajar & rapi, serta mendukung Dark Mode */
                    #area-pagination nav svg { width: 1.25rem; height: 1.25rem; display: inline-block; }
                    #area-pagination nav p { margin-top: 0; margin-bottom: 0; }
                    .dark #area-pagination nav span[aria-disabled="true"] span { background-color: #1e293b; border-color: #334155; color: #64748b; }
                    .dark #area-pagination nav span[aria-current="page"] span { background-color: #3b82f6; border-color: #3b82f6; color: white; }
                    .dark #area-pagination nav a { background-color: #1e293b; border-color: #334155; color: #cbd5e1; }
                    .dark #area-pagination nav a:hover { background-color: #334155; color: white; }
                </style>
                {{ $pengembalians->links() }}
            </div>
        </div>

    </div>

    <!-- Script Live Search Pengembalian -->
    <script src="{{ asset('js/search-pengembalian.js') }}"></script>
</x-admin-layout>
