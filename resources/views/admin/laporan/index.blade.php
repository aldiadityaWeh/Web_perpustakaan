<x-admin-layout>
    @slot('title')
        Laporan Perpustakaan - Sistem Perpustakaan
    @endslot

    <div class="flex flex-col h-full min-h-full">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Laporan Perpustakaan</h1>
            <p class="text-sm text-gray-500 mt-1">Buat dan unduh rekapitulasi data perpustakaan dalam format PDF atau Excel</p>
        </div>

        <!-- Grid Menu Laporan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

            <!-- Kartu Laporan Peminjaman -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full">
                <div class="flex items-center gap-4 mb-4">
                    <div class="h-12 w-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl shrink-0">
                        <i class="ph ph-handshake"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Laporan Peminjaman</h2>
                        <p class="text-xs text-gray-500">Rekap transaksi peminjaman & pengembalian</p>
                    </div>
                </div>

                <form action="{{ route('laporan.peminjaman') }}" method="GET" target="_blank" class="flex flex-col gap-4 mt-auto">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Dari Tanggal</label>
                            <input type="date" name="start_date" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-purple-600 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Sampai Tanggal</label>
                            <input type="date" name="end_date" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-purple-600 outline-none">
                        </div>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="submit" name="type" value="pdf" class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 py-2 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2">
                            <i class="ph ph-printer text-lg"></i> Cetak / PDF
                        </button>
                        <button type="submit" name="type" value="excel" class="flex-1 bg-green-50 hover:bg-green-100 text-green-700 border border-green-200 py-2 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2">
                            <i class="ph ph-file-xls text-lg"></i> Excel
                        </button>
                    </div>
                </form>
            </div>

            <!-- Kartu Laporan Data Buku -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full">
                <div class="flex items-center gap-4 mb-4">
                    <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl shrink-0">
                        <i class="ph ph-book-open"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Laporan Data Buku</h2>
                        <p class="text-xs text-gray-500">Rekap inventaris dan stok buku per kategori</p>
                    </div>
                </div>

                <form action="{{ route('laporan.buku') }}" method="GET" target="_blank" class="flex flex-col gap-4 mt-auto">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Filter Kategori (Opsional)</label>
                        <select name="kategori" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-purple-600 outline-none bg-white">
                            <option value="semua">Semua Kategori</option>
                            <option value="fiksi">Buku Fiksi</option>
                            <option value="non-fiksi">Buku Non-Fiksi</option>
                            <option value="pelajaran">Buku Pelajaran</option>
                        </select>
                    </div>
                    <!-- Spasi kosong agar tinggi tombol sejajar -->
                    <div class="h-[62px] hidden md:block"></div>
                    <div class="flex gap-3 pt-2">
                        <button type="submit" name="type" value="pdf" class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 py-2 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2">
                            <i class="ph ph-printer text-lg"></i> Cetak / PDF
                        </button>
                        <button type="submit" name="type" value="excel" class="flex-1 bg-green-50 hover:bg-green-100 text-green-700 border border-green-200 py-2 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2">
                            <i class="ph ph-file-xls text-lg"></i> Excel
                        </button>
                    </div>
                </form>
            </div>

            <!-- Kartu Laporan Anggota -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full">
                <div class="flex items-center gap-4 mb-4">
                    <div class="h-12 w-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl shrink-0">
                        <i class="ph ph-users"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Laporan Data Anggota</h2>
                        <p class="text-xs text-gray-500">Rekap data siswa yang terdaftar perpustakaan</p>
                    </div>
                </div>

                <form action="{{ route('laporan.anggota') }}" method="GET" target="_blank" class="flex flex-col gap-4 mt-auto">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Filter Kelas (Opsional)</label>
                        <select name="kelas" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-purple-600 outline-none bg-white">
                            <option value="semua">Semua Kelas</option>
                            <option value="1A">Kelas 1A</option>
                            <option value="2A">Kelas 2A</option>
                            <!-- Tambahkan kelas lain sesuai kebutuhan Anda -->
                        </select>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="submit" name="type" value="pdf" class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 py-2 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2">
                            <i class="ph ph-printer text-lg"></i> Cetak / PDF
                        </button>
                        <button type="submit" name="type" value="excel" class="flex-1 bg-green-50 hover:bg-green-100 text-green-700 border border-green-200 py-2 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2">
                            <i class="ph ph-file-xls text-lg"></i> Excel
                        </button>
                    </div>
                </form>
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
