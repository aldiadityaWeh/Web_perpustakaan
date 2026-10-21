<x-admin-layout>
    <x-slot:title>
        Manajemen Denda - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 space-y-6 w-full">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-slate-100 transition-colors">Tagihan Denda Siswa</h1>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1 transition-colors">Kelola data pembayaran denda keterlambatan atau kerusakan buku.</p>
            </div>

            <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center gap-2 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-300 border border-gray-200 dark:border-slate-600 px-5 py-2.5 rounded-xl font-medium transition-colors shadow-sm focus:outline-none shrink-0">
                <i class="ph ph-arrow-left text-lg"></i>
                Kembali ke Peminjaman
            </a>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors flex-1 flex flex-col">

            <!-- Toolbar Pencarian (Desain Kompak Menyatu dengan Tabel) -->
            <div class="p-4 border-b border-gray-100 dark:border-slate-700 flex flex-col sm:flex-row justify-between items-center gap-4 bg-gray-50/50 dark:bg-slate-800/50 transition-colors">
                <h2 class="text-sm font-bold text-gray-600 dark:text-slate-300 hidden sm:block">Daftar Tagihan Berjalan</h2>

                <form action="{{ route('denda.index') }}" method="GET" class="flex w-full sm:w-auto min-w-[280px]">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ph ph-magnifying-glass text-gray-400 dark:text-slate-500 text-lg"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" autocomplete="off" placeholder="Nama Siswa atau Judul Buku..."
                            class="pl-10 pr-3 w-full py-2 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 border-r-0 rounded-l-lg focus:ring-2 focus:ring-red-600 outline-none transition-colors text-sm text-gray-700 dark:text-slate-200 placeholder-gray-400 dark:placeholder-slate-500">
                    </div>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-r-lg font-medium transition-colors shadow-sm focus:outline-none shrink-0 text-sm border border-red-600 hover:border-red-700">
                        Cari Tagihan
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
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead class="bg-red-50/50 dark:bg-red-500/10 sticky top-0 z-10 border-b border-red-100 dark:border-red-500/20 transition-colors">
                        <tr class="text-red-800 dark:text-red-400 text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-4 px-6 w-16 text-center">No</th>
                            <th class="py-4 px-6">Nama Siswa</th>
                            <th class="py-4 px-6">Buku & Kondisi</th>
                            <th class="py-4 px-6 text-right">Nominal Denda</th>
                            <th class="py-4 px-6 text-center">Status Bayar</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-50 dark:divide-slate-700/50 transition-colors">
                        @forelse($peminjamans as $pinjam)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition-colors text-sm group">
                            <td class="py-4 px-6 text-gray-500 dark:text-slate-400 font-medium text-center">{{ $peminjamans->firstItem() + $loop->index }}</td>

                            <td class="py-4 px-6">
                                <span class="font-bold text-gray-800 dark:text-slate-200 block">{{ $pinjam->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</span>
                                <span class="text-xs text-gray-500 dark:text-slate-400 font-mono mt-0.5 block">NIS: {{ $pinjam->anggota->nis ?? '-' }}</span>
                            </td>

                            <td class="py-4 px-6">
                                <span class="font-medium text-gray-800 dark:text-slate-200 block line-clamp-1" title="{{ $pinjam->buku->judul ?? '-' }}">{{ $pinjam->buku->judul ?? 'Buku Dihapus' }}</span>
                                <span class="text-[11px] text-gray-400 dark:text-slate-500 mt-1 line-clamp-1 block">{{ $pinjam->catatan ?? 'Tidak ada catatan khusus' }}</span>
                            </td>

                            <td class="py-4 px-6 text-right">
                                <span class="font-black text-red-600 dark:text-red-400 text-base block transition-colors">
                                    Rp {{ number_format($pinjam->denda, 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="py-4 px-6 text-center">
                                @if($pinjam->status_denda == 'Lunas')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20 text-[10px] font-bold rounded-full uppercase tracking-wider transition-colors">
                                        <i class="ph ph-check-circle-fill text-sm"></i> LUNAS
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-500/20 text-[10px] font-bold rounded-full uppercase tracking-wider animate-pulse transition-colors">
                                        <i class="ph ph-warning-circle-fill text-sm"></i> BELUM LUNAS
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-center">
                                <!-- Desain Aksi Border Menyatu -->
                                <div class="inline-flex items-center justify-center p-1 bg-white dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm gap-1 transition-colors">
                                    <a href="{{ route('peminjaman.show', $pinjam->id) }}" class="p-1.5 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 rounded-lg transition-colors" title="Lihat Detail Transaksi">
                                        <i class="ph ph-eye text-lg font-bold"></i>
                                    </a>

                                    @if($pinjam->status_denda != 'Lunas')
                                        <div class="w-px h-4 bg-gray-200 dark:bg-slate-700"></div>

                                        <div x-data="{ showLunasModal: false }" class="inline-block relative">
                                            <button @click="showLunasModal = true" type="button" class="bg-gray-900 dark:bg-slate-800 hover:bg-black dark:hover:bg-slate-700 border border-transparent dark:border-slate-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm flex items-center gap-1.5">
                                                <i class="ph ph-hand-coins text-base"></i> Terima Uang
                                            </button>

                                            <!-- Modal Konfirmasi Lunas -->
                                            <div x-show="showLunasModal" x-cloak class="fixed inset-0 z-[99] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 text-left">
                                                <div @click.away="showLunasModal = false" class="bg-white dark:bg-slate-800 rounded-2xl p-6 w-full max-w-sm shadow-2xl transform transition-all border border-transparent dark:border-slate-700">
                                                    <div class="flex items-center gap-4 mb-5">
                                                        <div class="w-12 h-12 rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl shrink-0 transition-colors">
                                                            <i class="ph ph-money"></i>
                                                        </div>
                                                        <div>
                                                            <h3 class="font-bold text-gray-900 dark:text-slate-100 text-base">Konfirmasi Pembayaran</h3>
                                                            <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Pastikan Anda sudah menerima uangnya.</p>
                                                        </div>
                                                    </div>
                                                    <div class="bg-gray-50 dark:bg-slate-900 p-4 rounded-xl border border-gray-100 dark:border-slate-700 mb-6 text-center transition-colors">
                                                        <p class="text-[10px] text-gray-500 dark:text-slate-400 mb-1 uppercase font-bold tracking-widest">Total Terima</p>
                                                        <p class="text-2xl font-black text-gray-900 dark:text-slate-100">Rp {{ number_format($pinjam->denda, 0, ',', '.') }}</p>
                                                    </div>
                                                    <div class="flex justify-end gap-3">
                                                        <button @click="showLunasModal = false" type="button" class="px-4 py-2.5 text-sm font-bold text-gray-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 flex-1 transition-colors">Batal</button>

                                                        <form action="{{ route('denda.lunas', $pinjam->id) }}" method="POST" class="flex-1 m-0 p-0">
                                                            @csrf
                                                            <button type="submit" class="w-full px-4 py-2.5 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-md transition-colors">Sudah Lunas</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 rounded-full bg-gray-50 dark:bg-slate-800 border-4 border-gray-100 dark:border-slate-700 flex items-center justify-center mb-3 transition-colors">
                                        <i class="ph ph-check-circle text-4xl text-emerald-400 dark:text-emerald-500"></i>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-800 dark:text-slate-100">Tidak ada tagihan denda</h3>
                                    <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mt-1">Semua siswa tertib atau pencarian tidak ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination dengan CSS override untuk mode gelap -->
            <div class="p-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 mt-auto transition-colors">
                <style>
                    /* Penyesuaian SVG agar pagination default Laravel terlihat sejajar di dark mode */
                    .p-4 nav svg { width: 1.25rem; height: 1.25rem; display: inline-block; }
                    .p-4 nav p { margin-top: 0; margin-bottom: 0; }
                    .dark .p-4 nav span[aria-disabled="true"] span { background-color: #1e293b; border-color: #334155; color: #64748b; }
                    .dark .p-4 nav span[aria-current="page"] span { background-color: #3b82f6; border-color: #3b82f6; color: white; }
                    .dark .p-4 nav a { background-color: #1e293b; border-color: #334155; color: #cbd5e1; }
                    .dark .p-4 nav a:hover { background-color: #334155; color: white; }
                </style>
                {{ $peminjamans->links() }}
            </div>
        </div>

    </div>
</x-admin-layout>
