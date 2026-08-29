<x-admin-layout>
    @slot('title')
        Riwayat Transaksi - Sistem Perpustakaan
    @endslot

    <div class="flex flex-col h-full min-h-full">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Riwayat Transaksi</h1>
                <p class="text-sm text-gray-500 mt-1">Log keseluruhan aktivitas peminjaman dan pengembalian buku</p>
            </div>

            <!-- Tombol Cetak / Ekspor Laporan -->
            <button type="button" class="inline-flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-5 py-2.5 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                <i class="ph ph-printer text-lg"></i>
                Cetak Laporan
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6 flex flex-col md:flex-row gap-4">

            <!-- Search Input -->
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="ph ph-magnifying-glass text-gray-400 text-lg"></i>
                </div>
                <input type="text" placeholder="Cari ID Transaksi, Nama Siswa, atau Judul Buku..."
                    class="pl-11 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-700 placeholder-gray-400">
            </div>

            <!-- Filters -->
            <div class="flex items-center gap-3 shrink-0">
                <!-- Filter Waktu Dropdown -->
                <div class="relative">
                    <select class="appearance-none pl-4 pr-10 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm bg-white text-gray-700 cursor-pointer w-full md:w-40">
                        <option value="semua">Semua Waktu</option>
                        <option value="hari_ini">Hari Ini</option>
                        <option value="minggu_ini">Minggu Ini</option>
                        <option value="bulan_ini">Bulan Ini</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <i class="ph ph-caret-down text-gray-500"></i>
                    </div>
                </div>

                <!-- Filter Status Dropdown -->
                <div class="relative">
                    <select class="appearance-none pl-4 pr-10 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm bg-white text-gray-700 cursor-pointer w-full md:w-40">
                        <option value="semua">Semua Status</option>
                        <option value="selesai">Selesai</option>
                        <option value="terlambat">Selesai (Terlambat)</option>
                        <option value="hilang">Buku Hilang</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <i class="ph ph-caret-down text-gray-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="bg-purple-50/50 border-b border-gray-100 text-gray-500 text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-4 px-6">ID TRANSAKSI</th>
                            <th class="py-4 px-6">PEMINJAM (KELAS)</th>
                            <th class="py-4 px-6">JUDUL BUKU</th>
                            <th class="py-4 px-6">TGL PINJAM</th>
                            <th class="py-4 px-6">TGL KEMBALI</th>
                            <th class="py-4 px-6">STATUS</th>
                            <th class="py-4 px-6 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Empty State View -->
                        <tr>
                            <td colspan="7" class="py-24 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="ph ph-receipt text-6xl mb-4 text-gray-300"></i>
                                    <p class="text-sm font-medium text-gray-500">Belum ada riwayat transaksi</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <footer class="bg-purple-800 text-white p-5 rounded-xl flex flex-col sm:flex-row justify-between items-center gap-4 text-sm mt-auto shadow-md">
            <div class="text-center sm:text-left">
                <p class="font-bold text-base mb-0.5">Sistem Perpustakaan Sekolah</p>
                <p class="text-purple-300 text-xs tracking-wide">&copy; 2026 - Sistem Dibangun oleh Agung Prastiyo</p>
            </div>
            <div class="flex gap-5 text-xl">
                <a href="#" class="text-purple-200 hover:text-white transition-colors" title="Github">
                    <i class="ph ph-github-logo"></i>
                </a>
                <a href="#" class="text-purple-200 hover:text-white transition-colors" title="Bantuan">
                    <i class="ph ph-question"></i>
                </a>
            </div>
        </footer>

    </div>
</x-admin-layout>
