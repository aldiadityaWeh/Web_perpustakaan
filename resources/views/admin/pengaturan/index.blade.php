<x-admin-layout>
    <x-slot:title>
        Pengaturan Sistem - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 min-h-[85vh] w-full transition-colors">

        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-slate-100 transition-colors">Pengaturan Sistem</h1>
            <p class="text-sm text-gray-500 dark:text-slate-400 mt-1 transition-colors">Kelola identitas perpustakaan dan aturan sirkulasi peminjaman.</p>
        </div>

        <!-- NOTIFIKASI SUKSES -->
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 p-4 rounded-xl flex items-center gap-3 border border-emerald-100 dark:border-emerald-500/20 transition-colors shadow-sm">
                <i class="ph ph-check-circle text-xl"></i>
                <p class="text-sm font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        <!-- FORM PENGATURAN -->
        <form action="{{ route('pengaturan.update') }}" method="POST" class="space-y-6 mb-8 w-full max-w-4xl">
            @csrf
            @method('PUT')

            <!-- KOTAK 1: IDENTITAS SEKOLAH -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 sm:p-8 transition-colors">
                <div class="flex items-center gap-3.5 mb-6 pb-4 border-b border-gray-100 dark:border-slate-700 transition-colors">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-500/10 flex items-center justify-center border border-purple-100 dark:border-purple-500/20 text-purple-600 dark:text-purple-400 shrink-0 transition-colors">
                        <i class="ph ph-buildings text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-slate-100 transition-colors">Identitas Sekolah</h3>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5 transition-colors">Atur nama instansi dan data kepala perpustakaan untuk cetak laporan.</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 dark:text-slate-400 uppercase mb-1.5 transition-colors">Nama Sekolah / Perpustakaan <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $pengaturan->nama_sekolah) }}" required
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-800 dark:text-slate-200 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-purple-600 dark:focus:ring-purple-500 outline-none text-sm transition shadow-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 dark:text-slate-400 uppercase mb-1.5 transition-colors">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat_sekolah" rows="3"
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-800 dark:text-slate-200 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-purple-600 dark:focus:ring-purple-500 outline-none text-sm transition shadow-sm resize-none">{{ old('alamat_sekolah', $pengaturan->alamat_sekolah) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 dark:text-slate-400 uppercase mb-1.5 transition-colors">Nama Kepala Perpus <span class="text-red-500">*</span></label>
                            <input type="text" name="kepala_perpustakaan" value="{{ old('kepala_perpustakaan', $pengaturan->kepala_perpustakaan) }}"
                                class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-800 dark:text-slate-200 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-purple-600 dark:focus:ring-purple-500 outline-none text-sm transition shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 dark:text-slate-400 uppercase mb-1.5 transition-colors">NIP Kepala <span class="text-red-500">*</span></label>
                            <input type="text" name="nip_kepala" value="{{ old('nip_kepala', $pengaturan->nip_kepala) }}"
                                class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-800 dark:text-slate-200 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-purple-600 dark:focus:ring-purple-500 outline-none text-sm transition shadow-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOTAK 2: ATURAN SIRKULASI -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 sm:p-8 transition-colors">
                <div class="flex items-center gap-3.5 mb-6 pb-4 border-b border-gray-100 dark:border-slate-700 transition-colors">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center border border-blue-100 dark:border-blue-500/20 text-blue-600 dark:text-blue-400 shrink-0 transition-colors">
                        <i class="ph ph-arrows-left-right text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-slate-100 transition-colors">Aturan Sirkulasi</h3>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5 transition-colors">Konfigurasi batas maksimal peminjaman dan nominal denda harian.</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 dark:text-slate-400 uppercase mb-1.5 transition-colors">Nominal Denda Per Hari (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="denda_per_hari" value="{{ old('denda_per_hari', $pengaturan->denda_per_hari) }}" min="0" required
                            class="w-full px-4 py-2.5 border border-red-200 dark:border-red-500/30 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-purple-600 dark:focus:ring-purple-500 outline-none text-sm transition font-bold text-red-600 dark:text-red-400 bg-red-50/50 dark:bg-red-500/10 shadow-sm">
                        <p class="text-[10px] text-gray-400 dark:text-slate-500 mt-1.5 transition-colors">Kosongkan (isi 0) jika perpustakaan tidak menerapkan sistem denda.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 dark:text-slate-400 uppercase mb-1.5 transition-colors">Batas Hari Pinjam <span class="text-red-500">*</span></label>
                            <div class="flex items-center gap-3">
                                <input type="number" name="maksimal_hari_pinjam" value="{{ old('maksimal_hari_pinjam', $pengaturan->maksimal_hari_pinjam) }}" min="1" required
                                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-800 dark:text-slate-200 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-purple-600 dark:focus:ring-purple-500 outline-none text-sm transition shadow-sm">
                                <span class="text-sm font-semibold text-gray-500 dark:text-slate-400 shrink-0 transition-colors">Hari</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 dark:text-slate-400 uppercase mb-1.5 transition-colors">Maks. Pinjam Buku <span class="text-red-500">*</span></label>
                            <div class="flex items-center gap-3">
                                <input type="number" name="maksimal_buku_pinjam" value="{{ old('maksimal_buku_pinjam', $pengaturan->maksimal_buku_pinjam) }}" min="1" required
                                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-800 dark:text-slate-200 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-purple-600 dark:focus:ring-purple-500 outline-none text-sm transition shadow-sm">
                                <span class="text-sm font-semibold text-gray-500 dark:text-slate-400 shrink-0 transition-colors">Buku</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TOMBOL SIMPAN -->
            <div class="flex justify-end pt-2">
                <button type="submit" class="w-full sm:w-auto bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-xl text-sm font-semibold transition-colors flex items-center justify-center gap-2 shadow-sm">
                    <i class="ph ph-floppy-disk text-lg"></i>
                    <span>Simpan Pengaturan</span>
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>
