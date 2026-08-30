<x-admin-layout>
    @slot('title')
        Analisis Perpustakaan - Sistem Perpustakaan
    @endslot

    <!-- Include Chart.js untuk menampilkan grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="flex flex-col h-full min-h-full">
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Analisis Perpustakaan</h1>
                <p class="text-sm text-gray-500 mt-1">Pantau statistik, tren peminjaman, dan performa perpustakaan</p>
            </div>

            <!-- Filter Waktu -->
            <div class="relative">
                <select class="appearance-none pl-4 pr-10 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm bg-white text-gray-700 cursor-pointer font-medium shadow-sm">
                    <option value="7hari" selected>7 Hari Terakhir</option>
                    <option value="bulan_ini">Bulan Ini</option>
                    <option value="tahun_ini">Tahun Ini</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <i class="ph ph-calendar-blank text-gray-500 text-lg"></i>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Transaksi -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">TOTAL TRANSAKSI (BULAN INI)</p>
                    <div class="h-8 w-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                        <i class="ph ph-arrows-left-right"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-800">124</h3>
                <p class="text-xs text-emerald-500 flex items-center gap-1 mt-2 font-medium">
                    <i class="ph ph-arrow-up-right"></i> Naik 12% dari bulan lalu
                </p>
            </div>

            <!-- Rata-rata Pinjam -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">RATA-RATA PINJAM / HARI</p>
                    <div class="h-8 w-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                        <i class="ph ph-chart-bar"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-800">17 <span class="text-sm font-normal text-gray-400">Buku</span></h3>
                <p class="text-xs text-emerald-500 flex items-center gap-1 mt-2 font-medium">
                    Performa Optimal
                </p>
            </div>

            <!-- Overdue -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">BUKU TERLAMBAT (SAAT INI)</p>
                    <div class="h-8 w-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center text-lg">
                        <i class="ph ph-bell-ringing"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-800">3</h3>
                <p class="text-xs text-red-500 flex items-center gap-1 mt-2 font-medium">
                    Perlu ditindaklanjuti
                </p>
            </div>

            <!-- Anggota Aktif -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">ANGGOTA AKTIF</p>
                    <div class="h-8 w-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
                        <i class="ph ph-users"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-800">85%</h3>
                <p class="text-xs text-gray-400 flex items-center gap-1 mt-2 font-medium">
                    Siswa rutin meminjam buku
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

            <!-- Line Chart (Tren Peminjaman) -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 lg:col-span-2 flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="font-bold text-gray-800 text-base">Tren Peminjaman Harian</h3>
                        <p class="text-xs text-gray-500 mt-1">Aktivitas peminjaman 7 hari terakhir</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-gray-500">
                        <span class="flex items-center gap-1"><div class="w-3 h-3 rounded bg-[#8b5cf6]"></div> Jumlah Peminjaman</span>
                    </div>
                </div>
                <div class="flex-1 w-full relative min-h-[250px]">
                    <canvas id="lineChartPeminjaman"></canvas>
                </div>
            </div>

            <!-- Donut Chart (Distribusi Kategori) -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-gray-800 text-base">Distribusi Kategori</h3>
                </div>
                <div class="flex-1 w-full relative min-h-[200px] flex items-center justify-center mb-4">
                    <canvas id="donutChartKategori"></canvas>
                </div>
                <!-- Legend -->
                <div class="mt-auto flex flex-col gap-3 pt-4 border-t border-gray-50">
                    <div class="flex justify-between items-center text-sm">
                        <span class="flex items-center gap-2 text-gray-600"><div class="w-2.5 h-2.5 rounded-full bg-[#8b5cf6]"></div> Pelajaran</span>
                        <span class="font-bold text-gray-800">65%</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="flex items-center gap-2 text-gray-600"><div class="w-2.5 h-2.5 rounded-full bg-[#3b82f6]"></div> Fiksi / Cerita</span>
                        <span class="font-bold text-gray-800">25%</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="flex items-center gap-2 text-gray-600"><div class="w-2.5 h-2.5 rounded-full bg-[#10b981]"></div> Non-Fiksi</span>
                        <span class="font-bold text-gray-800">10%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <!-- Peminjaman Terbaru -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col p-6">
                <h3 class="font-bold text-gray-800 text-base mb-5">Peminjaman Terbaru</h3>
                <div class="flex flex-col gap-3">

                    <div class="flex items-center justify-between p-3 bg-gray-50/80 rounded-xl border border-gray-100/50">
                        <div>
                            <p class="text-sm font-bold text-gray-800">Mempelajari Teknik Informatika</p>
                            <p class="text-xs text-gray-500 mt-0.5">Agung Prastiyo</p>
                        </div>
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">
                            dikembalikan
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50/80 rounded-xl border border-gray-100/50">
                        <div>
                            <p class="text-sm font-bold text-gray-800">Buku Pintar Matematika</p>
                            <p class="text-xs text-gray-500 mt-0.5">Budi Santoso</p>
                        </div>
                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">
                            dipinjam
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50/80 rounded-xl border border-gray-100/50">
                        <div>
                            <p class="text-sm font-bold text-gray-800">Sejarah Kemerdekaan RI</p>
                            <p class="text-xs text-gray-500 mt-0.5">Citra Lestari</p>
                        </div>
                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">
                            dipinjam
                        </span>
                    </div>
                </div>
            </div>

            <!-- Buku Populer -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col p-6">
                <h3 class="font-bold text-gray-800 text-base mb-5">Buku Populer</h3>
                <div class="flex flex-col gap-3">

                    <div class="flex items-center justify-between p-3 bg-gray-50/80 rounded-xl border border-gray-100/50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-lg">
                                <i class="ph ph-book-bookmark"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800 line-clamp-1">Dongeng Anak Nusantara</p>
                                <p class="text-xs text-gray-500 mt-0.5">Kategori: Fiksi</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-800">42x</p>
                            <p class="text-[10px] text-gray-500">dipinjam</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50/80 rounded-xl border border-gray-100/50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg">
                                <i class="ph ph-book-bookmark"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800 line-clamp-1">Mempelajari Teknik Informatika</p>
                                <p class="text-xs text-gray-500 mt-0.5">Kategori: Pelajaran</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-800">38x</p>
                            <p class="text-[10px] text-gray-500">dipinjam</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50/80 rounded-xl border border-gray-100/50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">
                                <i class="ph ph-book-bookmark"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800 line-clamp-1">Buku Pintar Matematika</p>
                                <p class="text-xs text-gray-500 mt-0.5">Kategori: Pelajaran</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-800">25x</p>
                            <p class="text-[10px] text-gray-500">dipinjam</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Konfigurasi Font Global
            Chart.defaults.font.family = "'Inter', sans-serif";
            Chart.defaults.color = '#9ca3af';

            // 1. Line Chart (Mirip dengan screenshot referensi)
            const ctxLine = document.getElementById('lineChartPeminjaman').getContext('2d');

            // Efek area di bawah garis (gradient)
            let gradientLine = ctxLine.createLinearGradient(0, 0, 0, 300);
            gradientLine.addColorStop(0, 'rgba(139, 92, 246, 0.4)'); // Purple 500
            gradientLine.addColorStop(1, 'rgba(139, 92, 246, 0.05)');

            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: ['Kam', 'Jum', 'Sab', 'Min', 'Sen', 'Sel', 'Rab'],
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: [0, 0, 0, 0, 0, 0, 1], // Data seperti di screenshot (naik di akhir)
                        borderColor: '#8b5cf6', // Ungu
                        backgroundColor: gradientLine,
                        borderWidth: 2,
                        tension: 0.4, // Melengkung
                        fill: true,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#8b5cf6',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { backgroundColor: '#1f2937', padding: 10, cornerRadius: 8 }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [4, 4], color: '#f3f4f6' },
                            ticks: { stepSize: 1 } // Karena datanya kecil di screenshot
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // 2. Donut Chart
            const ctxDonut = document.getElementById('donutChartKategori').getContext('2d');
            new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: ['Pelajaran', 'Fiksi / Cerita', 'Non-Fiksi'],
                    datasets: [{
                        data: [65, 25, 10],
                        backgroundColor: ['#8b5cf6', '#3b82f6', '#10b981'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%', // Ketebalan donut
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
