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

    <form action="#" method="POST" class="max-w-4xl">
        @csrf

        <div class="flex flex-col gap-6 mb-8">

            <!-- KARTU 1: IDENTITAS SEKOLAH -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-white flex items-center gap-3">
                    <i class="ph ph-buildings text-purple-600 text-xl font-bold"></i>
                    <h2 class="text-base font-bold text-gray-800">Identitas Sekolah</h2>
                </div>

                <div class="p-6 flex flex-col gap-6">
                    <!-- Alamat / Kota (Full width karena Nama Perpustakaan dihapus) -->
                    <div>
                        <label for="alamat_sekolah" class="block text-sm text-gray-600 mb-2">Kota / Kabupaten</label>
                        <input type="text" id="alamat_sekolah" name="alamat_sekolah" value="Purwakarta" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Nama Kepala Sekolah -->
                        <div>
                            <label for="kepala_sekolah" class="block text-sm text-gray-600 mb-2">Nama Kepala Sekolah</label>
                            <input type="text" id="kepala_sekolah" name="kepala_sekolah" value="Budi Sudarsono, S.Pd" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                        </div>
                        <!-- NIP Kepala Sekolah -->
                        <div>
                            <label for="nip_kepala_sekolah" class="block text-sm text-gray-600 mb-2">NIP Kepala Sekolah</label>
                            <input type="text" id="nip_kepala_sekolah" name="nip_kepala_sekolah" value="19801234 200501 1 001" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                        </div>
                    </div>
                </div>
            </div>

            <!-- KARTU 2: ATURAN PEMINJAMAN -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-white flex items-center gap-3">
                    <i class="ph ph-handshake text-purple-600 text-xl font-bold"></i>
                    <h2 class="text-base font-bold text-gray-800">Aturan Peminjaman</h2>
                </div>

                <div class="p-6 flex flex-col gap-6">
                    <!-- Maksimal Hari & Buku -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="maksimal_hari" class="block text-sm text-gray-600 mb-2">Maksimal Lama Pinjam</label>
                            <div class="relative">
                                <input type="number" id="maksimal_hari" name="maksimal_hari" value="7" min="1" class="w-full pl-4 pr-16 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-sm text-gray-400">
                                    Hari
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="maksimal_buku" class="block text-sm text-gray-600 mb-2">Maksimal Jumlah Buku</label>
                            <div class="relative">
                                <input type="number" id="maksimal_buku" name="maksimal_buku" value="2" min="1" class="w-full pl-4 pr-16 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-sm text-gray-400">
                                    Buku
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <!-- Toggle Denda -->
                    <div class="flex items-center justify-between" x-data="{ dendaAktif: true }">
                        <div>
                            <p class="text-sm font-medium text-gray-800">Berlakukan Denda Keterlambatan</p>
                            <p class="text-xs text-gray-500 mt-0.5">Aktifkan untuk menerapkan denda uang jika siswa telat mengembalikan.</p>
                        </div>
                        <!-- Toggle UI bergaya iOS -->
                        <button type="button"
                                @click="dendaAktif = !dendaAktif"
                                :class="dendaAktif ? 'bg-purple-600' : 'bg-gray-200'"
                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2">
                            <span aria-hidden="true"
                                  :class="dendaAktif ? 'translate-x-5' : 'translate-x-0'"
                                  class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            <!-- Hidden input untuk menangkap value form -->
                            <input type="hidden" name="status_denda" :value="dendaAktif ? '1' : '0'">
                        </button>
                    </div>

                    <!-- Nominal Denda (Hanya muncul jika denda aktif) -->
                    <div>
                        <label for="denda_per_hari" class="block text-sm text-gray-600 mb-2">Nominal Denda (Per Hari)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-sm font-medium text-gray-500">
                                Rp
                            </div>
                            <input type="number" id="denda_per_hari" name="denda_per_hari" value="500" min="0" step="100" class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                        </div>
                    </div>
                </div>
            </div>

            <!-- KARTU 3: PREFERENSI CETAK -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-white flex items-center gap-3">
                    <i class="ph ph-printer text-purple-600 text-xl font-bold"></i>
                    <h2 class="text-base font-bold text-gray-800">Preferensi Cetak Laporan</h2>
                </div>

                <div class="p-6 flex flex-col gap-6" x-data="{ kopSurat: true, ttd: true }">
                    <!-- Toggle Kop Surat -->
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-800">Tampilkan Kop Sekolah</p>
                            <p class="text-xs text-gray-500 mt-0.5">Tampilkan nama dan alamat sekolah di bagian atas laporan PDF.</p>
                        </div>
                        <button type="button" @click="kopSurat = !kopSurat" :class="kopSurat ? 'bg-purple-600' : 'bg-gray-200'" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                            <span aria-hidden="true" :class="kopSurat ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            <input type="hidden" name="tampil_kop" :value="kopSurat ? '1' : '0'">
                        </button>
                    </div>

                    <hr class="border-gray-50">

                    <!-- Toggle Tanda Tangan -->
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-800">Kolom Tanda Tangan Kepala Sekolah</p>
                            <p class="text-xs text-gray-500 mt-0.5">Tambahkan ruang untuk tanda tangan basah di halaman terakhir laporan.</p>
                        </div>
                        <button type="button" @click="ttd = !ttd" :class="ttd ? 'bg-purple-600' : 'bg-gray-200'" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                            <span aria-hidden="true" :class="ttd ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            <input type="hidden" name="tampil_ttd" :value="ttd ? '1' : '0'">
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <div class="flex justify-start">
            <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-purple-600 border border-transparent rounded-xl hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors shadow-sm flex items-center justify-center gap-2">
                Simpan Perubahan
            </button>
        </div>
    </form>

</x-admin-layout>
