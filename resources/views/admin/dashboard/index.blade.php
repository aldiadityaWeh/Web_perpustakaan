<x-admin-layout>
    @slot('title')
        Dashboard - Sistem Perpustakaan
    @endslot

    <div class="flex flex-col h-full min-h-full">
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, Administrator 👋</h1>
                <p class="text-sm text-gray-500 mt-1">Berikut adalah ringkasan aktivitas perpustakaan Anda hari ini.</p>
            </div>
            <div class="bg-white px-4 py-2.5 rounded-xl shadow-sm border border-gray-100 text-sm font-semibold text-gray-700 flex items-center gap-2 w-fit transform hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                <i class="ph ph-calendar-blank text-purple-600 text-lg"></i>
                <span id="currentDate">Memuat tanggal...</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Buku -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:border-purple-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer group">
                <div class="h-14 w-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-3xl shrink-0 group-hover:scale-110 group-hover:bg-blue-100 transition-all duration-300">
                    <i class="ph ph-books"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Koleksi</p>
                    <h3 class="text-2xl font-extrabold text-gray-800">1,240 <span class="text-sm font-normal text-gray-500">Buku</span></h3>
                </div>
            </div>

            <!-- Anggota Aktif -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:border-purple-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer group">
                <div class="h-14 w-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl shrink-0 group-hover:scale-110 group-hover:bg-emerald-100 transition-all duration-300">
                    <i class="ph ph-users"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Anggota Aktif</p>
                    <h3 class="text-2xl font-extrabold text-gray-800">356 <span class="text-sm font-normal text-gray-500">Siswa</span></h3>
                </div>
            </div>

            <!-- Sedang Dipinjam -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:border-purple-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer group">
                <div class="h-14 w-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-3xl shrink-0 group-hover:scale-110 group-hover:bg-amber-100 transition-all duration-300">
                    <i class="ph ph-handshake"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Sedang Dipinjam</p>
                    <h3 class="text-2xl font-extrabold text-gray-800">42 <span class="text-sm font-normal text-gray-500">Buku</span></h3>
                </div>
            </div>

            <!-- Jatuh Tempo -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:border-red-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer group">
                <div class="h-14 w-14 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center text-3xl shrink-0 group-hover:scale-110 group-hover:bg-red-100 transition-all duration-300">
                    <i class="ph ph-warning-circle"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Jatuh Tempo</p>
                    <h3 class="text-2xl font-extrabold text-gray-800">3 <span class="text-sm font-normal text-gray-500">Transaksi</span></h3>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col">
                <h3 class="font-bold text-gray-800 text-base mb-4 flex items-center gap-2">
                    <i class="ph ph-lightning text-purple-600"></i> Aksi Cepat
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('peminjaman.create') }}" class="flex flex-col items-center justify-center gap-2 p-4 bg-purple-50/50 hover:bg-purple-100 text-purple-700 rounded-xl transition-colors text-center border border-purple-100/50 group">
                        <i class="ph ph-handshake text-2xl group-hover:scale-110 transition-transform"></i>
                        <span class="text-xs font-semibold">Peminjaman Baru</span>
                    </a>
                    <a href="{{ route('pengembalian.index') }}" class="flex flex-col items-center justify-center gap-2 p-4 bg-blue-50/50 hover:bg-blue-100 text-blue-700 rounded-xl transition-colors text-center border border-blue-100/50 group">
                        <i class="ph ph-clock-counter-clockwise text-2xl group-hover:scale-110 transition-transform"></i>
                        <span class="text-xs font-semibold">Pengembalian</span>
                    </a>
                    <a href="{{ route('buku.create') }}" class="flex flex-col items-center justify-center gap-2 p-4 bg-emerald-50/50 hover:bg-emerald-100 text-emerald-700 rounded-xl transition-colors text-center border border-emerald-100/50 group">
                        <i class="ph ph-book-open text-2xl group-hover:scale-110 transition-transform"></i>
                        <span class="text-xs font-semibold">Tambah Buku</span>
                    </a>
                    <a href="{{ route('anggota.create') }}" class="flex flex-col items-center justify-center gap-2 p-4 bg-amber-50/50 hover:bg-amber-100 text-amber-700 rounded-xl transition-colors text-center border border-amber-100/50 group">
                        <i class="ph ph-user-plus text-2xl group-hover:scale-110 transition-transform"></i>
                        <span class="text-xs font-semibold">Tambah Anggota</span>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col lg:col-span-2 overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
                    <div>
                        <h3 class="font-bold text-gray-800 text-base">Perlu Perhatian</h3>
                        <p class="text-xs text-gray-500">Buku yang harus dikembalikan hari ini atau terlambat</p>
                    </div>
                    <a href="{{ route('peminjaman.index') }}" class="text-xs font-semibold text-purple-600 hover:text-purple-700 bg-purple-50 px-3 py-1.5 rounded-lg transition-colors">Lihat Semua</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-gray-400 text-[10px] font-bold uppercase tracking-wider">
                                <th class="py-3 px-5">Peminjam</th>
                                <th class="py-3 px-5">Buku</th>
                                <th class="py-3 px-5">Tgl Kembali</th>
                                <th class="py-3 px-5 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                <td class="py-3 px-5 font-medium text-gray-800">Dika Permana</td>
                                <td class="py-3 px-5 text-gray-600 truncate max-w-[150px]">Matematika Kelas 5</td>
                                <td class="py-3 px-5 text-gray-600">30 Ags 2026</td>
                                <td class="py-3 px-5 text-right">
                                    <span class="inline-block px-2.5 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">Terlambat</span>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                <td class="py-3 px-5 font-medium text-gray-800">Siti Aminah</td>
                                <td class="py-3 px-5 text-gray-600 truncate max-w-[150px]">Kisah Nabi Musa</td>
                                <td class="py-3 px-5 text-gray-600">30 Ags 2026</td>
                                <td class="py-3 px-5 text-right">
                                    <span class="inline-block px-2.5 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">Hari Ini</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3 px-5 font-medium text-gray-800">Budi Santoso</td>
                                <td class="py-3 px-5 text-gray-600 truncate max-w-[150px]">IPA Terpadu Kelas 6</td>
                                <td class="py-3 px-5 text-gray-600">30 Ags 2026</td>
                                <td class="py-3 px-5 text-right">
                                    <span class="inline-block px-2.5 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">Hari Ini</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menampilkan Tanggal Hari Ini secara dinamis
            const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const today = new Date().toLocaleDateString('id-ID', dateOptions);
            document.getElementById('currentDate').textContent = today;
        });
    </script>
</x-admin-layout>
