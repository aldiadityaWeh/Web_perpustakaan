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

    <!-- Alert Sukses -->
    @if(session('success'))
        <div class="mb-6 max-w-4xl bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl flex items-center gap-3 text-emerald-700 text-sm font-medium shadow-sm">
            <i class="ph ph-check-circle text-xl"></i>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('pengaturan.update') }}" method="POST" class="max-w-4xl">
        @csrf
        @method('PUT')

        <div class="flex flex-col gap-6 mb-8">

            <!-- KARTU 1: IDENTITAS SEKOLAH -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-white flex items-center gap-3">
                    <i class="ph ph-buildings text-purple-600 text-xl font-bold"></i>
                    <h2 class="text-base font-bold text-gray-800">Identitas Sekolah</h2>
                </div>

                <div class="p-6 flex flex-col gap-6">
                    <div>
                        <label for="alamat_sekolah" class="block text-sm text-gray-600 mb-2">Kota / Kabupaten</label>
                        <input type="text" id="alamat_sekolah" name="alamat_sekolah" value="{{ old('alamat_sekolah', $pengaturan->alamat_sekolah) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="kepala_sekolah" class="block text-sm text-gray-600 mb-2">Nama Kepala Sekolah</label>
                            <input type="text" id="kepala_sekolah" name="kepala_sekolah" value="{{ old('kepala_sekolah', $pengaturan->kepala_sekolah) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                        </div>
                        <div>
                            <label for="nip_kepala_sekolah" class="block text-sm text-gray-600 mb-2">NIP Kepala Sekolah</label>
                            <input type="text" id="nip_kepala_sekolah" name="nip_kepala_sekolah" value="{{ old('nip_kepala_sekolah', $pengaturan->nip_kepala_sekolah) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="maksimal_hari" class="block text-sm text-gray-600 mb-2">Maksimal Lama Pinjam</label>
                            <div class="relative">
                                <input type="number" id="maksimal_hari" name="maksimal_hari" value="{{ old('maksimal_hari', $pengaturan->maksimal_hari) }}" min="1" class="w-full pl-4 pr-16 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-sm text-gray-400">Hari</div>
                            </div>
                        </div>
                        <div>
                            <label for="maksimal_buku" class="block text-sm text-gray-600 mb-2">Maksimal Jumlah Buku</label>
                            <div class="relative">
                                <input type="number" id="maksimal_buku" name="maksimal_buku" value="{{ old('maksimal_buku', $pengaturan->maksimal_buku) }}" min="1" class="w-full pl-4 pr-16 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-sm text-gray-400">Buku</div>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <div>
                        <label for="denda_per_hari" class="block text-sm text-gray-600 mb-2">Nominal Denda (Per Hari)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-sm font-medium text-gray-500">Rp</div>
                            <input type="number" id="denda_per_hari" name="denda_per_hari" value="{{ old('denda_per_hari', $pengaturan->denda_per_hari) }}" min="0" step="100" class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                        </div>
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
