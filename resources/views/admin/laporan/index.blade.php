<x-admin-layout>
    <x-slot:title>
        Laporan Cetak - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 w-full">
        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-slate-100 transition-colors">Cetak Laporan</h1>
            <p class="text-sm text-gray-500 dark:text-slate-400 mt-1 transition-colors">Unduh atau cetak dokumen rekap data perpustakaan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <!-- 1. Laporan Peminjaman -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col h-full hover:shadow-md transition-all relative overflow-hidden group">
                <!-- Ikon Kotak (Ungu) -->
                <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-500/10 flex items-center justify-center mb-5 border border-purple-100 dark:border-purple-500/20 shrink-0 transition-all group-hover:scale-110">
                    <img src="{{ asset('images/document.png') }}" alt="Ikon Sirkulasi" class="w-7 h-7 object-contain dark:opacity-90">
                </div>

                <h3 class="text-[17px] font-bold text-gray-900 dark:text-slate-100 mb-2 transition-colors">Laporan Sirkulasi</h3>
                <p class="text-sm text-gray-500 dark:text-slate-400 mb-8 leading-relaxed transition-colors">Rekap riwayat peminjaman, pengembalian, dan denda.</p>

                <!-- Form Filter Tanggal -->
                <form action="{{ route('laporan.peminjaman') }}" method="GET" target="_blank" class="mt-auto flex flex-col gap-4">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1.5 transition-colors">Dari Tgl</label>
                            <input type="date" name="start_date" class="w-full text-sm text-gray-700 dark:text-slate-200 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-lg px-3 py-2.5 outline-none focus:border-purple-600 focus:ring-1 focus:ring-purple-600 transition-colors [color-scheme:light] dark:[color-scheme:dark]" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1.5 transition-colors">Sampai Tgl</label>
                            <input type="date" name="end_date" class="w-full text-sm text-gray-700 dark:text-slate-200 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-lg px-3 py-2.5 outline-none focus:border-purple-600 focus:ring-1 focus:ring-purple-600 transition-colors [color-scheme:light] dark:[color-scheme:dark]" required>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-xl text-sm font-bold transition-colors flex items-center justify-center gap-2 mt-1 shadow-sm">
                        <i class="ph ph-printer text-lg"></i>
                        <span>Cetak Laporan</span>
                    </button>
                </form>
            </div>

            <!-- 2. Laporan Buku -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col h-full hover:shadow-md transition-all group">
                <!-- Ikon Kotak (Biru) -->
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center mb-5 border border-blue-100 dark:border-blue-500/20 shrink-0 transition-all group-hover:scale-110">
                    <img src="{{ asset('images/buku.png') }}" alt="Ikon Buku" class="w-7 h-7 object-contain dark:opacity-90">
                </div>

                <h3 class="text-[17px] font-bold text-gray-900 dark:text-slate-100 mb-2 transition-colors">Inventaris Buku</h3>
                <p class="text-sm text-gray-500 dark:text-slate-400 mb-8 leading-relaxed transition-colors">Daftar ketersediaan judul buku dan stok saat ini.</p>

                <a href="{{ route('laporan.buku') }}" target="_blank" class="mt-auto w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl text-sm font-bold transition-colors flex items-center justify-center gap-2 shadow-sm">
                    <i class="ph ph-printer text-lg"></i>
                    <span>Cetak Data Buku</span>
                </a>
            </div>

            <!-- 3. Laporan Anggota -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col h-full hover:shadow-md transition-all group">
                <!-- Ikon Kotak (Hijau/Emerald) -->
                <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center mb-5 border border-emerald-100 dark:border-emerald-500/20 shrink-0 transition-all group-hover:scale-110">
                    <img src="{{ asset('images/anggota.png') }}" alt="Ikon Anggota" class="w-7 h-7 object-contain dark:opacity-90">
                </div>

                <h3 class="text-[17px] font-bold text-gray-900 dark:text-slate-100 mb-2 transition-colors">Data Anggota</h3>
                <p class="text-sm text-gray-500 dark:text-slate-400 mb-8 leading-relaxed transition-colors">Daftar siswa yang aktif sebagai anggota perpustakaan.</p>

                <a href="{{ route('laporan.anggota') }}" target="_blank" class="mt-auto w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-xl text-sm font-bold transition-colors flex items-center justify-center gap-2 shadow-sm">
                    <i class="ph ph-printer text-lg"></i>
                    <span>Cetak Data Anggota</span>
                </a>
            </div>

        </div>
    </div>
</x-admin-layout>
