<x-admin-layout>
    <x-slot:title>
        Kas Denda - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 space-y-6">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-slate-100 transition-colors">Kas Denda Perpustakaan</h1>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1 transition-colors">Laporan pemasukan dari denda keterlambatan dan kerusakan buku</p>
            </div>

            <a href="{{ route('denda.index') }}" class="inline-flex items-center gap-2 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-500/30 px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors shadow-sm shrink-0">
                <i class="ph ph-receipt text-lg font-bold"></i>
                Lihat Tagihan Belum Lunas
            </a>
        </div>

        <!-- KARTU TOTAL KAS -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-6 sm:p-8 shadow-md text-white flex items-center gap-5 relative overflow-hidden transition-colors">
            <i class="ph ph-wallet absolute -right-4 -bottom-6 text-[120px] text-white opacity-10"></i>
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm shrink-0 border border-white/30 shadow-inner">
                <i class="ph ph-money text-4xl text-white"></i>
            </div>
            <div class="relative z-10">
                <p class="text-purple-100 text-sm font-bold tracking-wider uppercase mb-1">Total Pemasukan Kas Denda (Lunas)</p>
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight">Rp {{ number_format($totalKas, 0, ',', '.') }}</h2>
            </div>
        </div>

        <!-- WADAH TABEL (Pencarian Menyatu) -->
        <div id="table-container" class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors flex-1 flex flex-col">

            <!-- Toolbar Tabel -->
            <div class="p-4 border-b border-gray-100 dark:border-slate-700 flex flex-col sm:flex-row justify-between items-center gap-4 bg-gray-50/50 dark:bg-slate-800/50 transition-colors">
                <h2 class="text-sm font-bold text-gray-600 dark:text-slate-300 hidden sm:block">Riwayat Pemasukan Kas</h2>

                <form id="searchForm" action="{{ route('transaksi.index') }}" method="GET" class="flex w-full sm:w-auto min-w-[280px]">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ph ph-magnifying-glass text-gray-400 dark:text-slate-500 text-lg"></i>
                        </div>
                        <input type="text" id="searchInput" name="search" value="{{ request('search') }}" autocomplete="off" placeholder="Cari TRX-ID, nama, atau buku..."
                            class="pl-10 pr-3 w-full py-2 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 border-r-0 rounded-l-lg focus:ring-2 focus:ring-purple-600 outline-none transition-colors text-sm text-gray-700 dark:text-slate-200 placeholder-gray-400 dark:placeholder-slate-500">
                    </div>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-r-lg font-medium transition-colors shadow-sm focus:outline-none shrink-0 flex items-center justify-center gap-2 text-sm border border-purple-600 hover:border-purple-700 cursor-pointer">
                        <span>Cari</span>
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead class="bg-purple-50/50 dark:bg-slate-900/50 sticky top-0 z-10 border-b border-gray-200 dark:border-slate-700 transition-colors">
                        <tr class="text-gray-500 dark:text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-4 px-6 text-center w-16">No</th>
                            <th class="py-4 px-6">ID & Waktu Masuk</th>
                            <th class="py-4 px-6">Identitas Pembayar</th>
                            <th class="py-4 px-6">Keterangan Denda</th>
                            <th class="py-4 px-6 text-right">Nominal Masuk</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-50 dark:divide-slate-700/50 transition-colors">
                        @forelse($transaksis as $trx)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition-colors text-sm group">

                            <!-- Kolom Nomor Urut -->
                            <td class="py-4 px-6 text-center font-medium text-gray-500 dark:text-slate-400">
                                {{ $loop->iteration + ($transaksis->currentPage() - 1) * $transaksis->perPage() }}
                            </td>

                            <!-- Kolom Kode TRX & Tanggal -->
                            <td class="py-4 px-6 text-gray-600 dark:text-slate-300">
                                <span class="inline-block px-2 py-0.5 bg-purple-50 dark:bg-purple-500/10 text-purple-700 dark:text-purple-400 border border-purple-200 dark:border-purple-500/20 rounded text-[10px] font-mono font-bold mb-1">
                                    TRX-{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                                <span class="font-semibold block transition-colors">{{ \Carbon\Carbon::parse($trx->updated_at)->format('d M Y') }}</span>
                                <span class="text-[10px] text-gray-400 dark:text-slate-500 mt-0.5 block transition-colors">{{ \Carbon\Carbon::parse($trx->updated_at)->format('H:i') }} WIB</span>
                            </td>

                            <!-- Kolom Siswa -->
                            <td class="py-4 px-6">
                                <span class="font-bold text-gray-800 dark:text-slate-200 block transition-colors">{{ $trx->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</span>
                                <span class="text-xs text-gray-500 dark:text-slate-400 font-mono mt-0.5 block transition-colors">NIS: {{ $trx->anggota->nis ?? '-' }}</span>
                            </td>

                            <!-- Kolom Keterangan -->
                            <td class="py-4 px-6">
                                <div class="text-xs text-gray-600 dark:text-slate-300 transition-colors max-w-xs">
                                    <div class="truncate" title="{{ $trx->buku->judul ?? '-' }}">
                                        <span class="font-medium text-gray-800 dark:text-slate-200">Buku:</span> {{ $trx->buku->judul ?? 'Buku Dihapus' }}
                                    </div>
                                    <div class="mt-1 truncate" title="{{ filled($trx->catatan) ? $trx->catatan : 'Terlambat' }}">
                                        <span class="font-medium text-gray-800 dark:text-slate-200">Sebab:</span>
                                        <span class="text-red-500 dark:text-red-400 font-bold">{{ filled($trx->catatan) ? $trx->catatan : 'Terlambat' }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Kolom Nominal -->
                            <td class="py-4 px-6 text-right font-black text-emerald-600 dark:text-emerald-400 text-base transition-colors whitespace-nowrap">
                                + Rp {{ number_format($trx->denda, 0, ',', '.') }}
                            </td>

                            <!-- Kolom Aksi -->
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center justify-center p-1 bg-white dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm gap-1 transition-colors">
                                    <a href="{{ route('peminjaman.show', $trx->id) }}" class="p-1.5 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 rounded-lg transition-colors" title="Lihat Detail Transaksi">
                                        <i class="ph ph-eye text-lg"></i>
                                    </a>

                                    @if(auth()->user()->role === 'admin')
                                        <div class="w-px h-4 bg-gray-200 dark:bg-slate-700 mx-0.5"></div>
                                        <form action="{{ route('transaksi.destroy', $trx->id) }}" method="POST" class="m-0 p-0" onsubmit="event.preventDefault(); konfirmasiHapusKas(this);">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors cursor-pointer" title="Hapus Riwayat Kas">
                                                <i class="ph ph-trash text-lg"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center -mt-4">
                                    <div class="w-24 h-24 rounded-full bg-purple-50 dark:bg-slate-700 border-8 border-white dark:border-slate-800 shadow-sm flex items-center justify-center mb-4 transition-colors">
                                        <i class="ph ph-receipt text-4xl text-purple-500 dark:text-slate-400 block leading-none"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-slate-200 mb-1">Belum Ada Transaksi</h3>
                                    <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mb-6">Pencarian tidak ditemukan atau kas denda masih kosong.</p>
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
                    #area-pagination nav svg { width: 1.25rem; height: 1.25rem; display: inline-block; }
                    #area-pagination nav p { margin-top: 0; margin-bottom: 0; }
                    .dark #area-pagination nav span[aria-disabled="true"] span { background-color: #1e293b; border-color: #334155; color: #64748b; }
                    .dark #area-pagination nav span[aria-current="page"] span { background-color: #3b82f6; border-color: #3b82f6; color: white; }
                    .dark #area-pagination nav a { background-color: #1e293b; border-color: #334155; color: #cbd5e1; }
                    .dark #area-pagination nav a:hover { background-color: #334155; color: white; }
                </style>
                {{ $transaksis->links() }}
            </div>
        </div>

    </div>

    <!-- Panggil File JS Eksternal di folder Public -->
    <script src="{{ asset('js/search-transaksi.js') }}"></script>

    <!-- Konfirmasi SweetAlert untuk Hapus Riwayat Kas -->
    <script>
        function konfirmasiHapusKas(form) {
            const isDark = document.documentElement.classList.contains('dark');

            Swal.fire({
                title: 'Hapus Riwayat Kas?',
                text: "Data transaksi ini akan dihapus permanen dan mengurangi total saldo kas denda.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: isDark ? '#334155' : '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                background: isDark ? '#1e293b' : '#ffffff',
                color: isDark ? '#f8fafc' : '#1e293b',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border ' + (isDark ? 'border-slate-700' : 'border-transparent'),
                    confirmButton: 'px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm',
                    cancelButton: 'px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
</x-admin-layout>
