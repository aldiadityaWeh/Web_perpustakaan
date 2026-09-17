<x-admin-layout>
    <x-slot:title>
        Laporan Cetak - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 min-h-[85vh] w-full">
        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Cetak Laporan</h1>
            <p class="text-sm text-gray-500 mt-1">Unduh atau cetak rekapitulasi data perpustakaan sebagai dokumen fisik.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <!-- 1. Laporan Peminjaman -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full relative overflow-hidden">
                <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-2xl mb-4"><i class="ph ph-handshake"></i></div>
                <h3 class="text-lg font-bold text-gray-800">Laporan Sirkulasi</h3>
                <p class="text-sm text-gray-500 mb-6 mt-1">Rekap data peminjaman, pengembalian, dan denda siswa.</p>

                <form action="{{ route('laporan.peminjaman') }}" method="GET" target="_blank" class="mt-auto flex flex-col gap-3 border-t border-gray-50 pt-4">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Dari Tgl</label>
                            <input type="date" name="start_date" class="w-full text-xs border border-gray-200 rounded-lg px-2 py-2 outline-none focus:border-purple-500" required>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Sampai Tgl</label>
                            <input type="date" name="end_date" class="w-full text-xs border border-gray-200 rounded-lg px-2 py-2 outline-none focus:border-purple-500" required>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2.5 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                        <i class="ph ph-printer"></i> Cetak Peminjaman
                    </button>
                </form>
            </div>

            <!-- 2. Laporan Buku -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl mb-4"><i class="ph ph-books"></i></div>
                <h3 class="text-lg font-bold text-gray-800">Laporan Inventaris Buku</h3>
                <p class="text-sm text-gray-500 mb-6 mt-1">Cetak seluruh daftar buku beserta sisa stok saat ini.</p>

                <a href="{{ route('laporan.buku') }}" target="_blank" class="mt-auto w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                    <i class="ph ph-printer"></i> Cetak Data Buku
                </a>
            </div>

            <!-- 3. Laporan Anggota -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl mb-4"><i class="ph ph-users"></i></div>
                <h3 class="text-lg font-bold text-gray-800">Laporan Data Anggota</h3>
                <p class="text-sm text-gray-500 mb-6 mt-1">Daftar siswa yang telah terdaftar sebagai anggota perpustakaan.</p>

                <a href="{{ route('laporan.anggota') }}" target="_blank" class="mt-auto w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                    <i class="ph ph-printer"></i> Cetak Data Anggota
                </a>
            </div>

        </div>
    </div>
</x-admin-layout>
