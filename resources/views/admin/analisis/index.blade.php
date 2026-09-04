<x-admin-layout>
    @slot('title')
        Analisis Perpustakaan - Sistem Perpustakaan
    @endslot

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="flex flex-col h-full min-h-full">
        <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Analisis Perpustakaan</h1>
                <p class="text-sm text-gray-500 mt-1">Pantau statistik, tren peminjaman, dan performa perpustakaan secara Real-Time</p>
            </div>

            <!-- FORM FILTER TANGGAL BARU -->
            <form action="{{ route('analisis.index') }}" method="GET" class="bg-white p-2 rounded-xl shadow-sm border border-gray-100 flex items-center gap-2 w-fit">
                <div class="flex items-center gap-2 px-2">
                    <i class="ph ph-calendar-blank text-gray-400"></i>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="text-sm text-gray-700 bg-transparent outline-none cursor-pointer" required>
                </div>
                <span class="text-gray-300 font-bold">-</span>
                <div class="flex items-center gap-2 px-2">
                    <input type="date" name="end_date" value="{{ $endDate }}" class="text-sm text-gray-700 bg-transparent outline-none cursor-pointer" required>
                </div>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1.5 rounded-lg text-sm font-semibold transition-colors flex items-center gap-1">
                    <i class="ph ph-funnel"></i> Filter
                </button>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

            <!-- Card 1: Total Transaksi -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:border-blue-200 group">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">TOTAL TRANSAKSI</p>
                    <div class="h-8 w-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-lg transition-transform duration-300 group-hover:scale-110 group-hover:bg-blue-100">
                        <i class="ph ph-arrows-left-right"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-800">{{ $totalTransaksi }}</h3>
                <p class="text-[10px] text-blue-500 flex items-center gap-1 mt-2 font-medium line-clamp-1">
                    Dari {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}
                </p>
            </div>

            <!-- Card 2: Rata-rata Pinjam -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:border-emerald-200 group">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">RATA-RATA PINJAM / HARI</p>
                    <div class="h-8 w-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg transition-transform duration-300 group-hover:scale-110 group-hover:bg-emerald-100">
                        <i class="ph ph-chart-bar"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-800">{{ $rataPinjam }} <span class="text-sm font-normal text-gray-400">Buku</span></h3>
                <p class="text-[10px] text-emerald-500 flex items-center gap-1 mt-2 font-medium">Sesuai rentang tanggal terpilih</p>
            </div>

            <!-- Card 3: Buku Terlambat -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:border-red-200 group">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">BUKU TERLAMBAT (SAAT INI)</p>
                    <div class="h-8 w-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center text-lg transition-transform duration-300 group-hover:scale-110 group-hover:bg-red-100">
                        <i class="ph ph-bell-ringing"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-800">{{ $bukuTerlambat }}</h3>
                <p class="text-xs {{ $bukuTerlambat > 0 ? 'text-red-500' : 'text-gray-400' }} flex items-center gap-1 mt-2 font-medium">
                    {{ $bukuTerlambat > 0 ? 'Perlu ditindaklanjuti segera!' : 'Tidak ada tunggakan' }}
                </p>
            </div>

            <!-- Card 4: Anggota Aktif -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:border-purple-200 group">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">ANGGOTA AKTIF</p>
                    <div class="h-8 w-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-lg transition-transform duration-300 group-hover:scale-110 group-hover:bg-purple-100">
                        <i class="ph ph-users"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-800">{{ $persenAnggota }}%</h3>
                <p class="text-xs text-gray-400 flex items-center gap-1 mt-2 font-medium">Siswa yg pernah meminjam</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

            <!-- Line Chart (Tren Peminjaman) -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 lg:col-span-2 flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="font-bold text-gray-800 text-base">Grafik Peminjaman</h3>
                        <p class="text-xs text-gray-500 mt-1">
                            Aktivitas peminjaman dari {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M') }} hingga {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}
                        </p>
                    </div>
                </div>
                <div class="flex-1 w-full relative min-h-[250px]">
                    <canvas id="lineChartPeminjaman"></canvas>
                </div>
            </div>

            <!-- Donut Chart (Distribusi Kategori) -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-gray-800 text-base">Koleksi Berdasarkan Kategori</h3>
                </div>
                <div class="flex-1 w-full relative min-h-[200px] flex items-center justify-center mb-4">
                    @if(count($dataKategori) > 0)
                        <canvas id="donutChartKategori"></canvas>
                    @else
                        <p class="text-sm text-gray-400 text-center">Belum ada data buku.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <!-- Peminjaman Terbaru -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col p-6">
                <h3 class="font-bold text-gray-800 text-base mb-5">Peminjaman Terbaru</h3>
                <div class="flex flex-col gap-3">
                    @forelse($peminjamanTerbaru as $trx)
                        <div class="flex items-center justify-between p-3 bg-gray-50/80 rounded-xl border border-gray-100/50">
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $trx->buku->judul ?? 'Buku Dihapus' }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $trx->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</p>
                            </div>
                            <span class="px-3 py-1 text-[10px] font-bold rounded-lg uppercase tracking-wider
                                {{ $trx->status == 'dipinjam' ? 'bg-amber-100 text-amber-700' : '' }}
                                {{ $trx->status == 'dikembalikan' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $trx->status == 'terlambat' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ $trx->status }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-4">Belum ada transaksi peminjaman.</p>
                    @endforelse
                </div>
            </div>

            <!-- Buku Populer -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col p-6">
                <h3 class="font-bold text-gray-800 text-base mb-5">Buku Paling Populer</h3>
                <div class="flex flex-col gap-3">
                    @forelse($bukuPopuler as $populer)
                        <div class="flex items-center justify-between p-3 bg-gray-50/80 rounded-xl border border-gray-100/50">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-lg">
                                    <i class="ph ph-trend-up"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 line-clamp-1">{{ $populer->buku->judul ?? 'Buku Dihapus' }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Kategori: {{ ucfirst($populer->buku->kategori ?? '-') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-800">{{ $populer->total_pinjam }}x</p>
                                <p class="text-[10px] text-gray-500">dipinjam</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-4">Belum ada statistik buku.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            Chart.defaults.font.family = "'Inter', sans-serif";
            Chart.defaults.color = '#9ca3af';

            // Mengambil Data PHP ke JavaScript
            const chartDates = @json($chartDates);
            const chartData = @json($chartData);

            const labelKategori = @json($labelKategori);
            const dataKategori = @json($dataKategori);

            // 1. Line Chart (Tren Peminjaman 7 Hari)
            const ctxLine = document.getElementById('lineChartPeminjaman');
            if (ctxLine) {
                let gradientLine = ctxLine.getContext('2d').createLinearGradient(0, 0, 0, 300);
                gradientLine.addColorStop(0, 'rgba(139, 92, 246, 0.4)');
                gradientLine.addColorStop(1, 'rgba(139, 92, 246, 0.05)');

                new Chart(ctxLine, {
                    type: 'line',
                    data: {
                        labels: chartDates,
                        datasets: [{
                            label: 'Peminjaman',
                            data: chartData,
                            borderColor: '#8b5cf6',
                            backgroundColor: gradientLine,
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#8b5cf6',
                            pointBorderWidth: 2,
                            pointRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { borderDash: [4, 4] } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            // 2. Donut Chart (Distribusi Kategori)
            const ctxDonut = document.getElementById('donutChartKategori');
            if (ctxDonut) {
                // Generate warna otomatis sesuai jumlah data
                const colors = ['#8b5cf6', '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#ec4899'];

                new Chart(ctxDonut, {
                    type: 'doughnut',
                    data: {
                        labels: labelKategori,
                        datasets: [{
                            data: dataKategori,
                            backgroundColor: colors.slice(0, dataKategori.length),
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: { position: 'bottom' }
                        }
                    }
                });
            }
        });
    </script>
</x-admin-layout>
