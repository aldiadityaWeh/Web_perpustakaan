<x-admin-layout>
    <x-slot:title>
        Validasi Pengembalian - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 w-full max-w-3xl mx-auto min-h-[85vh]">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('peminjaman.index') }}" class="w-10 h-10 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-full flex items-center justify-center text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors shadow-sm focus:outline-none">
                <i class="ph ph-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-slate-100 transition-colors">Validasi Pengembalian</h1>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1 transition-colors">Periksa kondisi buku dan pastikan aturan dipatuhi.</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">

            <!-- Info Peminjaman (Data Siswa & Buku) -->
            <div class="p-6 bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-slate-700 grid grid-cols-1 md:grid-cols-2 gap-6 transition-colors">
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-2">Data Siswa</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-500/20 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold shrink-0 transition-colors">
                            <i class="ph ph-user"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-slate-100 transition-colors">{{ $peminjaman->anggota->nama_lengkap }}</p>
                            <p class="text-xs text-gray-500 dark:text-slate-400 font-mono transition-colors">NIS: {{ $peminjaman->anggota->nis }}</p>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-2">Data Buku</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold shrink-0 transition-colors">
                            <i class="ph ph-book-open"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-slate-100 line-clamp-1 transition-colors">{{ $peminjaman->buku->judul }}</p>
                            <p class="text-xs text-gray-500 dark:text-slate-400 font-mono transition-colors">Kode/ISBN: {{ $peminjaman->buku->isbn }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Validasi -->
            <form action="{{ route('peminjaman.prosesValidasi', $peminjaman->id) }}" method="POST" class="p-6 space-y-6" x-data="{ kondisi: 'Baik' }">
                @csrf

                <!-- Alert Keterlambatan -->
                @if($peminjaman->hari_terlambat > 0)
                    <div class="bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 p-4 rounded-xl flex items-start gap-3 transition-colors">
                        <i class="ph ph-warning-circle text-red-600 dark:text-red-400 text-2xl shrink-0"></i>
                        <div>
                            <h4 class="font-bold text-red-800 dark:text-red-400 text-sm">Terlambat {{ $peminjaman->hari_terlambat }} Hari!</h4>
                            <p class="text-sm text-red-700 dark:text-red-300 mt-0.5">Siswa ini telah melewati batas waktu pengembalian. Sistem telah menghitung otomatis denda keterlambatan.</p>
                        </div>
                    </div>
                @else
                    <div class="bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 p-4 rounded-xl flex items-start gap-3 transition-colors">
                        <i class="ph ph-check-circle text-emerald-600 dark:text-emerald-400 text-2xl shrink-0"></i>
                        <div>
                            <h4 class="font-bold text-emerald-800 dark:text-emerald-400 text-sm">Tepat Waktu</h4>
                            <p class="text-sm text-emerald-700 dark:text-emerald-300 mt-0.5">Siswa mengembalikan buku sesuai jadwal. Tidak ada denda keterlambatan.</p>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Input Total Denda -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Total Tagihan (Rp)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-slate-400 font-bold">Rp</span>
                            </div>
                            <input type="number" name="denda" value="{{ $peminjaman->denda_berjalan }}" required min="0"
                                class="pl-12 w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition-colors font-bold text-gray-900 dark:text-slate-100 text-lg">
                        </div>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1.5">*Isi angka denda kerterlambatan / denda khusus di sini.</p>
                    </div>

                    <!-- Kondisi Buku -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Kondisi Saat Dikembalikan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ph ph-exam text-gray-400 dark:text-slate-500 text-lg"></i>
                            </div>
                            <select name="kondisi_buku" x-model="kondisi" required
                                class="pl-11 w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-purple-600 outline-none transition-colors appearance-none cursor-pointer font-bold text-gray-700 dark:text-slate-200">
                                <option value="Baik" class="dark:bg-slate-800">Bagus / Normal</option>
                                <option value="Rusak" class="dark:bg-slate-800">Rusak (Halaman Robek/Kotor)</option>
                                <option value="Hilang (Belum Diganti)" class="dark:bg-slate-800">Hilang (Siswa Belum Membawa Ganti)</option>
                                <option value="Hilang (Sudah Diganti)" class="dark:bg-slate-800">Hilang (Sudah Diganti Buku Fisik Sama)</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="ph ph-caret-down text-gray-400 dark:text-slate-500"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ATURAN MUTLAK WARNING (Muncul Jika Hilang Belum Diganti ATAU Rusak) -->
                <div x-show="kondisi === 'Hilang (Belum Diganti)' || kondisi === 'Rusak'" x-transition x-cloak
                     class="bg-red-50 dark:bg-red-500/10 border-l-4 border-red-600 dark:border-red-500 p-5 rounded-r-xl shadow-sm transition-colors">
                    <div class="flex items-start gap-3">
                        <i class="ph ph-prohibit text-red-600 dark:text-red-400 text-3xl animate-pulse shrink-0"></i>
                        <div>
                            <h4 class="font-black text-red-800 dark:text-red-400 text-sm uppercase tracking-widest mb-1">ATURAN MUTLAK: WAJIB GANTI BUKU!</h4>
                            <p class="text-sm text-red-700 dark:text-red-300 leading-relaxed">
                                Buku yang hilang atau rusak parah <strong>tidak boleh diganti dengan uang tunai</strong>. Siswa diwajibkan mencari dan menyerahkan buku fisik dengan judul yang sama persis.
                            </p>
                            <p class="text-xs font-bold text-red-800 dark:text-red-300 mt-2 bg-red-100 dark:bg-red-500/20 py-1.5 px-3 rounded-lg inline-block border border-red-200 dark:border-red-500/30">
                                <i class="ph ph-info"></i> Stok buku ini tidak akan dikembalikan ke sistem sebelum siswa menyerahkan buku barunya.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Catatan Tambahan -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Catatan Kepala Perpus (Opsional)</label>
                    <textarea name="catatan" rows="3" placeholder="Tuliskan catatan kondisi buku, janji ganti buku, atau rincian kerusakan di sini..."
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-purple-600 outline-none transition-colors text-sm text-gray-800 dark:text-slate-200 placeholder-gray-400 dark:placeholder-slate-500 resize-none"></textarea>
                </div>

                <div class="pt-6 border-t border-gray-100 dark:border-slate-700 flex justify-end gap-3 transition-colors">
                    <a href="{{ route('peminjaman.index') }}" class="px-6 py-3 text-sm font-bold text-gray-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors shadow-sm">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 text-sm font-bold text-white bg-purple-600 rounded-xl hover:bg-purple-700 shadow-md transition-all flex items-center gap-2">
                        Validasi & Kunci <i class="ph ph-lock-key text-lg"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
