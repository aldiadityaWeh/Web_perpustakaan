<x-admin-layout>
    @slot('title')
        Pengaturan Sistem - Sistem Perpustakaan
    @endslot

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pengaturan Sistem</h1>
            <p class="text-sm text-gray-500 mt-1">Sesuaikan identitas sekolah dan aturan peminjaman perpustakaan</p>
        </div>
    </div>

    <form action="#" method="POST">
        @csrf

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">

            <!-- KARTU 1: IDENTITAS PERPUSTAKAAN -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl shrink-0">
                        <i class="ph ph-buildings"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Identitas Sekolah</h2>
                        <p class="text-xs text-gray-500">Data ini akan digunakan sebagai kop pada laporan PDF</p>
                    </div>
                </div>

                <div class="p-6 flex flex-col gap-5">
                    <!-- Nama Perpustakaan -->
                    <div>
                        <label for="nama_perpustakaan" class="block text-sm font-semibold text-gray-700 mb-2">Nama Perpustakaan</label>
                        <input type="text" id="nama_perpustakaan" name="nama_perpustakaan" value="Perpustakaan SDN 1 Contoh" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                    </div>

                    <!-- Nama Kepala Sekolah -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="kepala_sekolah" class="block text-sm font-semibold text-gray-700 mb-2">Nama Kepala Sekolah</label>
                            <input type="text" id="kepala_sekolah" name="kepala_sekolah" value="Budi Sudarsono, S.Pd" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                        </div>
                        <div>
                            <label for="nip_kepala_sekolah" class="block text-sm font-semibold text-gray-700 mb-2">NIP Kepala Sekolah</label>
                            <input type="text" id="nip_kepala_sekolah" name="nip_kepala_sekolah" value="19801234 200501 1 001" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                        </div>
                    </div>

                    <!-- Alamat Sekolah -->
                    <div>
                        <label for="alamat_sekolah" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Sekolah</label>
                        <textarea id="alamat_sekolah" name="alamat_sekolah" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 resize-none">Jl. Pendidikan No. 123, Kota Belajar</textarea>
                    </div>
                </div>
            </div>

            <!-- KARTU 2: ATURAN PEMINJAMAN -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl shrink-0">
                        <i class="ph ph-sliders"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Aturan Sistem</h2>
                        <p class="text-xs text-gray-500">Konfigurasi batas waktu pinjam dan sanksi keterlambatan</p>
                    </div>
                </div>

                <div class="p-6 flex flex-col gap-5 flex-1">
                    <!-- Lama Pinjam -->
                    <div>
                        <label for="maksimal_hari" class="block text-sm font-semibold text-gray-700 mb-2">Maksimal Lama Pinjam</label>
                        <div class="relative">
                            <input type="number" id="maksimal_hari" name="maksimal_hari" value="7" min="1" class="w-full pl-4 pr-16 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-sm font-medium text-gray-500">
                                Hari
                            </div>
                        </div>
                        <p class="text-[11px] text-gray-400 mt-1">Batas waktu sebelum siswa dikenakan denda keterlambatan.</p>
                    </div>

                    <!-- Batas Jumlah Buku -->
                    <div>
                        <label for="maksimal_buku" class="block text-sm font-semibold text-gray-700 mb-2">Maksimal Pinjam Buku</label>
                        <div class="relative">
                            <input type="number" id="maksimal_buku" name="maksimal_buku" value="2" min="1" class="w-full pl-4 pr-16 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-sm font-medium text-gray-500">
                                Buku
                            </div>
                        </div>
                        <p class="text-[11px] text-gray-400 mt-1">Jumlah maksimal buku yang boleh dipinjam 1 siswa bersamaan.</p>
                    </div>

                    <!-- Nominal Denda -->
                    <div>
                        <label for="denda_per_hari" class="block text-sm font-semibold text-gray-700 mb-2">Nominal Denda (Per Hari)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-sm font-medium text-gray-500">
                                Rp
                            </div>
                            <input type="number" id="denda_per_hari" name="denda_per_hari" value="500" min="0" step="100" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                        </div>
                        <p class="text-[11px] text-gray-400 mt-1">Kosongkan atau isi 0 jika sekolah tidak memberlakukan denda uang.</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="flex justify-end">
            <button type="submit" class="w-full sm:w-auto px-8 py-3 text-sm font-semibold text-white bg-purple-600 border border-transparent rounded-xl hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors shadow-sm flex items-center justify-center gap-2">
                <i class="ph ph-check-circle text-lg"></i>
                Simpan Pengaturan
            </button>
        </div>
    </form>

</x-admin-layout>
