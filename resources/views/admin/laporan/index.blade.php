<x-admin-layout>
    <x-slot:title>
        Laporan Cetak - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 min-h-[85vh] w-full">
        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Cetak Laporan</h1>
            <p class="text-sm text-gray-500 mt-1">Unduh atau cetak dokumen rekap data perpustakaan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <!-- 1. Laporan Peminjaman -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center mb-5 border border-purple-100 shrink-0">
                    <img src="{{ asset('images/document.png') }}" alt="Ikon Sirkulasi" class="w-7 h-7 object-contain">
                </div>

                <h3 class="text-[17px] font-bold text-gray-900 mb-2">Laporan Sirkulasi</h3>
                <p class="text-sm text-gray-500 mb-8 leading-relaxed">Rekap riwayat peminjaman, pengembalian, dan denda.</p>

                <form action="{{ route('laporan.peminjaman') }}" method="GET" target="_blank" class="mt-auto flex flex-col gap-4">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Dari Tgl</label>
                            <input type="date" name="start_date" class="w-full text-sm text-gray-700 border border-gray-200 rounded-lg px-3 py-2.5 outline-none focus:border-[#a855f7] focus:ring-1 focus:ring-[#a855f7] transition-all" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Sampai Tgl</label>
                            <input type="date" name="end_date" class="w-full text-sm text-gray-700 border border-gray-200 rounded-lg px-3 py-2.5 outline-none focus:border-[#a855f7] focus:ring-1 focus:ring-[#a855f7] transition-all" required>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-[#a855f7] hover:bg-purple-600 text-white py-3 rounded-xl text-sm font-semibold transition-colors flex items-center justify-center gap-2 mt-1 shadow-sm">
                        <img src="{{ asset('images/unduh.png') }}" alt="Cetak" class="w-4 h-4 object-contain">
                        <span>Cetak Laporan</span>
                    </button>
                </form>
            </div>

            <!-- 2. Laporan Buku -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center mb-5 border border-blue-100 shrink-0">
                    <img src="{{ asset('images/buku.png') }}" alt="Ikon Buku" class="w-7 h-7 object-contain">
                </div>

                <h3 class="text-[17px] font-bold text-gray-900 mb-2">Inventaris Buku</h3>
                <p class="text-sm text-gray-500 mb-8 leading-relaxed">Daftar ketersediaan judul buku dan stok saat ini.</p>

                <a href="{{ route('laporan.buku') }}" target="_blank" class="mt-auto w-full bg-[#3b82f6] hover:bg-blue-600 text-white py-3 rounded-xl text-sm font-semibold transition-colors flex items-center justify-center gap-2 shadow-sm">
                    <img src="{{ asset('images/unduh.png') }}" alt="Cetak" class="w-4 h-4 object-contain">
                    <span>Cetak Data Buku</span>
                </a>
            </div>

            <!-- 3. Laporan Anggota -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center mb-5 border border-emerald-100 shrink-0">
                    <img src="{{ asset('images/anggota.png') }}" alt="Ikon Anggota" class="w-7 h-7 object-contain">
                </div>

                <h3 class="text-[17px] font-bold text-gray-900 mb-2">Data Anggota</h3>
                <p class="text-sm text-gray-500 mb-8 leading-relaxed">Daftar siswa yang aktif sebagai anggota perpustakaan.</p>

                <a href="{{ route('laporan.anggota') }}" target="_blank" class="mt-auto w-full bg-[#10b981] hover:bg-emerald-600 text-white py-3 rounded-xl text-sm font-semibold transition-colors flex items-center justify-center gap-2 shadow-sm">
                    <img src="{{ asset('images/unduh.png') }}" alt="Cetak" class="w-4 h-4 object-contain">
                    <span>Cetak Data Anggota</span>
                </a>
            </div>

        </div>
    </div>
</x-admin-layout>
