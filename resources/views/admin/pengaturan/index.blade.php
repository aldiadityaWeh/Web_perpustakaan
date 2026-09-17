<x-admin-layout>
    <x-slot:title>
        Pengaturan Sistem - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 min-h-[85vh] w-full">

        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Pengaturan Sistem</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola identitas perpustakaan dan aturan sirkulasi peminjaman</p>
        </div>

        <!-- NOTIFIKASI SUKSES -->
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 text-emerald-700 p-4 rounded-xl flex items-center gap-3 border border-emerald-100">
                <i class="ph ph-check-circle text-xl"></i>
                <p class="text-sm font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        <!-- FORM PENGATURAN -->
        <form action="{{ route('pengaturan.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- WADAH LACI (ACCORDION) DENGAN ALPINE.JS -->
            <div x-data="{ laciAktif: 1 }" class="space-y-4 mb-8">
                
                <!-- LACI 1: IDENTITAS SEKOLAH -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden transition-all duration-300" :class="laciAktif === 1 ? 'ring-2 ring-purple-100' : ''">
                    <!-- Kepala Laci (Tombol Buka/Tutup) -->
                    <button type="button" @click="laciAktif = laciAktif === 1 ? null : 1" class="w-full flex items-center justify-between p-5 bg-white hover:bg-gray-50 transition-colors focus:outline-none">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl shrink-0">
                                <i class="ph ph-buildings"></i>
                            </div>
                            <div class="text-left">
                                <h3 class="text-base font-bold text-gray-800">Identitas Sekolah</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Atur nama perpustakaan, alamat, dan data kepala sekolah untuk cetak laporan.</p>
                            </div>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center transition-transform duration-300" :class="laciAktif === 1 ? 'rotate-180 bg-purple-100 text-purple-600' : ''">
                            <i class="ph ph-caret-down text-lg"></i>
                        </div>
                    </button>
                    
                    <!-- Isi Laci 1 -->
                    <div x-show="laciAktif === 1" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                        <div class="p-6 border-t border-gray-100 bg-gray-50/50">
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Nama Sekolah / Perpustakaan <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $pengaturan->nama_sekolah) }}" required
                                        class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none text-sm transition shadow-sm">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Alamat Lengkap</label>
                                    <textarea name="alamat_sekolah" rows="3" 
                                        class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none text-sm transition shadow-sm">{{ old('alamat_sekolah', $pengaturan->alamat_sekolah) }}</textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Nama Kepala Perpus</label>
                                        <input type="text" name="kepala_perpustakaan" value="{{ old('kepala_perpustakaan', $pengaturan->kepala_perpustakaan) }}"
                                            class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none text-sm transition shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">NIP Kepala</label>
                                        <input type="text" name="nip_kepala" value="{{ old('nip_kepala', $pengaturan->nip_kepala) }}"
                                            class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none text-sm transition shadow-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- LACI 2: ATURAN SIRKULASI -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden transition-all duration-300" :class="laciAktif === 2 ? 'ring-2 ring-blue-100' : ''">
                    <!-- Kepala Laci (Tombol Buka/Tutup) -->
                    <button type="button" @click="laciAktif = laciAktif === 2 ? null : 2" class="w-full flex items-center justify-between p-5 bg-white hover:bg-gray-50 transition-colors focus:outline-none">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl shrink-0">
                                <i class="ph ph-handshake"></i>
                            </div>
                            <div class="text-left">
                                <h3 class="text-base font-bold text-gray-800">Aturan Sirkulasi</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Konfigurasi batas maksimal peminjaman dan nominal denda harian.</p>
                            </div>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center transition-transform duration-300" :class="laciAktif === 2 ? 'rotate-180 bg-blue-100 text-blue-600' : ''">
                            <i class="ph ph-caret-down text-lg"></i>
                        </div>
                    </button>
                    
                    <!-- Isi Laci 2 -->
                    <div x-show="laciAktif === 2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                        <div class="p-6 border-t border-gray-100 bg-gray-50/50">
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Nominal Denda Per Hari (Rp) <span class="text-red-500">*</span></label>
                                    <input type="number" name="denda_per_hari" value="{{ old('denda_per_hari', $pengaturan->denda_per_hari) }}" min="0" required
                                        class="w-full px-4 py-2.5 border border-red-200 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm transition font-bold text-red-600 bg-red-50 shadow-sm">
                                    <p class="text-[10px] text-gray-400 mt-1.5">Kosongkan (isi 0) jika perpustakaan tidak menerapkan sistem denda bagi siswa.</p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Batas Hari Pinjam <span class="text-red-500">*</span></label>
                                        <div class="flex items-center gap-3">
                                            <input type="number" name="maksimal_hari_pinjam" value="{{ old('maksimal_hari_pinjam', $pengaturan->maksimal_hari_pinjam) }}" min="1" required
                                                class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm transition shadow-sm">
                                            <span class="text-sm font-semibold text-gray-500 shrink-0">Hari</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Maks. Pinjam Buku <span class="text-red-500">*</span></label>
                                        <div class="flex items-center gap-3">
                                            <input type="number" name="maksimal_buku_pinjam" value="{{ old('maksimal_buku_pinjam', $pengaturan->maksimal_buku_pinjam) }}" min="1" required
                                                class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none text-sm transition shadow-sm">
                                            <span class="text-sm font-semibold text-gray-500 shrink-0">Buku</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- TOMBOL SIMPAN (Sticky bottom) -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex justify-end gap-3 mb-8">
                <button type="submit" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-900 text-white px-10 py-3 rounded-lg text-sm font-bold transition-colors flex items-center justify-center gap-2">
                    <i class="ph ph-floppy-disk text-lg"></i> Simpan Pengaturan
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>