<x-admin-layout>
    <x-slot:title>
        Analisis Perpustakaan - Sistem Perpustakaan
    </x-slot:title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="flex flex-col flex-1 w-full">
        <!-- HEADER & FILTER -->
        <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-slate-100 transition-colors">Analisis Perpustakaan</h1>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1 transition-colors">Pantau statistik, tren peminjaman, dan performa perpustakaan secara Real-Time</p>
            </div>

            <!-- FORM FILTER TANGGAL -->
            <form action="{{ route('analisis.index') }}" method="GET" class="bg-white dark:bg-slate-800 p-2 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 flex flex-wrap items-center gap-2 w-fit transition-colors">
                <div class="flex items-center gap-2 px-2">
                    <i class="ph ph-calendar-blank text-gray-400 dark:text-slate-500"></i>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="text-sm text-gray-700 dark:text-slate-200 bg-transparent outline-none cursor-pointer [color-scheme:light] dark:[color-scheme:dark]" required>
                </div>
                <span class="text-gray-300 dark:text-slate-600 font-bold">-</span>
                <div class="flex items-center gap-2 px-2">
                    <input type="date" name="end_date" value="{{ $endDate }}" class="text-sm text-gray-700 dark:text-slate-200 bg-transparent outline-none cursor-pointer [color-scheme:light] dark:[color-scheme:dark]" required>
                </div>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-1.5 rounded-lg text-sm font-semibold transition-colors flex items-center gap-1.5 shadow-sm">
                    <i class="ph ph-funnel"></i> Filter
                </button>
            </form>
        </div>

        <!-- SUMMARY CARDS (4 Kotak Atas) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

            <!-- Card 1: Total Transaksi -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-slate-700 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:border-blue-200 dark:hover:border-blue-500/50 group">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider">TOTAL TRANSAKSI</p>
                    <div class="h-8 w-8 rounded-lg bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center text-lg transition-transform duration-300 group-hover:scale-110 group-hover:bg-blue-100 dark:group-hover:bg-blue-500/20">
                        <i class="ph ph-arrows-left-right"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-gray-800 dark:text-slate-100 transition-colors">{{ $totalTransaksi }}</h3>
                <p class="text-[10px] text-blue-500 dark:text-blue-400 flex items-center gap-1 mt-2 font-medium line-clamp-1 transition-colors">
                    Dari {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}
                </p>
            </div>

            <!-- Card 2: Rata-rata Pinjam -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-slate-700 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:border-emerald-200 dark:hover:border-emerald-500/50 group">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider">RATA-RATA PINJAM / HARI</p>
                    <div class="h-8 w-8 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg transition-transform duration-300 group-hover:scale-110 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-500/20">
                        <i class="ph ph-chart-bar"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-gray-800 dark:text-slate-100 transition-colors">{{ $rataPinjam }} <span class="text-sm font-normal text-gray-400 dark:text-slate-500">Buku</span></h3>
                <p class="text-[10px] text-emerald-500 dark:text-emerald-400 flex items-center gap-1 mt-2 font-medium transition-colors">Sesuai rentang tanggal terpilih</p>
            </div>

            <!-- Card 3: Buku Terlambat -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-slate-700 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:border-red-200 dark:hover:border-red-500/50 group">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider">BUKU TERLAMBAT (SAAT INI)</p>
                    <div class="h-8 w-8 rounded-lg bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 flex items-center justify-center text-lg transition-transform duration-300 group-hover:scale-110 group-hover:bg-red-100 dark:group-hover:bg-red-500/20">
                        <i class="ph ph-bell-ringing"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-gray-800 dark:text-slate-100 transition-colors">{{ $bukuTerlambat }}</h3>
                <p class="text-xs {{ $bukuTerlambat > 0 ? 'text-red-500 dark:text-red-400' : 'text-gray-400 dark:text-slate-500' }} flex items-center gap-1 mt-2 font-medium transition-colors">
                    {{ $bukuTerlambat > 0 ? 'Perlu ditindaklanjuti segera!' : 'Tidak ada tunggakan' }}
                </p>
            </div>

            <!-- Card 4: Anggota Aktif -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-slate-700 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:border-purple-200 dark:hover:border-purple-500/50 group">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider">ANGGOTA AKTIF</p>
                    <div class="h-8 w-8 rounded-lg bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center text-lg transition-transform duration-300 group-hover:scale-110 group-hover:bg-purple-100 dark:group-hover:bg-purple-500/20">
                        <i class="ph ph-users"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-gray-800 dark:text-slate-100 transition-colors">{{ $persenAnggota }}%</h3>
                <p class="text-xs text-gray-400 dark:text-slate-500 flex items-center gap-1 mt-2 font-medium transition-colors">Siswa yg pernah meminjam</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

            <!-- Line Chart (Tren Peminjaman) -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 lg:col-span-2 flex flex-col transition-colors">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="font-bold text-gray-800 dark:text-slate-100 text-base transition-colors">Grafik Peminjaman</h3>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1 transition-colors">
                            Aktivitas peminjaman dari {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M') }} hingga {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}
                        </p>
                    </div>
                </div>
                <div class="flex-1 w-full relative min-h-[250px]">
                    <!-- Chart.js Canvas -->
                    <canvas id="lineChartPeminjaman"></canvas>
                </div>
            </div>

            <!-- Donut Chart (Distribusi Kategori) -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col transition-colors">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-gray-800 dark:text-slate-100 text-base transition-colors">Koleksi Berdasarkan Kategori</h3>
                </div>
                <div class="flex-1 w-full relative min-h-[200px] flex items-center justify-center mb-4">
                    @if(count($dataKategori) > 0)
                        <!-- Chart.js Canvas -->
                        <canvas id="donutChartKategori"></canvas>
                    @else
                        <p class="text-sm text-gray-400 dark:text-slate-500 text-center">Belum ada data buku.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <!-- Peminjaman Terbaru -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col p-6 transition-colors">
                <h3 class="font-bold text-gray-800 dark:text-slate-100 text-base mb-5 transition-colors">Peminjaman Terbaru</h3>
                <div class="flex flex-col gap-3 flex-1">
                    @forelse($peminjamanTerbaru as $trx)
                        <div class="flex items-center justify-between p-3 bg-gray-50/80 dark:bg-slate-900/50 rounded-xl border border-gray-100/50 dark:border-slate-700/50 transition-colors">
                            <div>
                                <p class="text-sm font-bold text-gray-800 dark:text-slate-200 transition-colors">{{ $trx->buku->judul ?? 'Buku Dihapus' }}</p>
                                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5 transition-colors">{{ $trx->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</p>
                            </div>
                            <span class="px-3 py-1 text-[10px] font-bold rounded-lg uppercase tracking-wider transition-colors
                                {{ $trx->status == 'dipinjam' ? 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400' : '' }}
                                {{ $trx->status == 'dikembalikan' ? 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400' : '' }}
                                {{ $trx->status == 'terlambat' ? 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400' : '' }}">
                                {{ $trx->status }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 dark:text-slate-500 text-center py-4 transition-colors">Belum ada transaksi peminjaman.</p>
                    @endforelse
                </div>

                <!-- Area Pagination -->
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-slate-700 transition-colors">
                    <style>
                        /* Styling khusus agar pagination Tailwind bawaan Laravel lebih rapi di dalam card */
                        .mt-4.pt-4 nav svg { width: 1.25rem; height: 1.25rem; }
                        .mt-4.pt-4 nav p { margin-top: 0; margin-bottom: 0; font-size: 0.75rem; }
                        .dark .mt-4.pt-4 nav span[aria-disabled="true"] span { background-color: #1e293b; border-color: #334155; color: #64748b; }
                        .dark .mt-4.pt-4 nav span[aria-current="page"] span { background-color: #3b82f6; border-color: #3b82f6; color: white; }
                        .dark .mt-4.pt-4 nav a { background-color: #1e293b; border-color: #334155; color: #cbd5e1; }
                        .dark .mt-4.pt-4 nav a:hover { background-color: #334155; color: white; }
                    </style>
                    {{ $peminjamanTerbaru->links() }}
                </div>
            </div>

            <!-- Buku Populer -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col p-6 transition-colors">
                <h3 class="font-bold text-gray-800 dark:text-slate-100 text-base mb-5 transition-colors">Buku Paling Populer</h3>
                <div class="flex flex-col gap-3">
                    @forelse($bukuPopuler as $index => $populer)
                        <div class="flex items-center justify-between p-3 bg-gray-50/80 dark:bg-slate-900/50 rounded-xl border border-gray-100/50 dark:border-slate-700/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <!-- Kotak Nomor Peringkat Berwarna dengan Dukungan Dark Mode -->
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg font-bold shadow-sm transition-colors
                                    {{ $index == 0 ? 'bg-gradient-to-br from-amber-200 to-amber-400 dark:from-amber-600 dark:to-amber-500 text-amber-900 dark:text-amber-50' :
                                      ($index == 1 ? 'bg-gradient-to-br from-gray-200 to-gray-300 dark:from-slate-600 dark:to-slate-500 text-gray-700 dark:text-slate-50' :
                                      ($index == 2 ? 'bg-gradient-to-br from-orange-200 to-orange-300 dark:from-orange-700 dark:to-orange-600 text-orange-900 dark:text-orange-50' :
                                      'bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 border border-purple-100 dark:border-purple-500/20')) }}">
                                    #{{ $index + 1 }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 dark:text-slate-200 line-clamp-1 transition-colors">{{ $populer->buku->judul ?? 'Buku Dihapus' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5 transition-colors">Kategori: {{ ucfirst($populer->buku->kategori ?? '-') }}</p>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-sm font-black text-gray-800 dark:text-slate-200 transition-colors">{{ $populer->total_pinjam }}x</p>
                                <p class="text-[10px] text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">dipinjam</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 dark:text-slate-500 text-center py-4 transition-colors">Belum ada statistik buku.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <!-- MENYIAPKAN DATA LARAVEL UNTUK FILE EXTERNAL JS -->
    <script>
        window.analisisData = {
            chartDates: @json($chartDates),
            chartData: @json($chartData),
            labelKategori: @json($labelKategori),
            dataKategori: @json($dataKategori)
        };
    </script>

    <!-- MEMANGGIL FILE EXTERNAL JS -->
    <script src="{{ asset('js/chart-analisis.js') }}"></script>
</x-admin-layout>
