<x-admin-layout>
    <x-slot:title>
        Validasi Pengembalian - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 w-full max-w-3xl mx-auto min-h-[85vh]">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('peminjaman.index') }}" class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center text-gray-600 hover:bg-gray-50 transition-colors shadow-sm">
                <i class="ph ph-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Validasi Pengembalian</h1>
                <p class="text-sm text-gray-500 mt-1">Periksa kondisi buku dan pastikan aturan dipatuhi.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Info Peminjaman -->
            <div class="p-6 bg-gray-50/50 border-b border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Data Siswa</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold">
                            <i class="ph ph-user"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $peminjaman->anggota->nama_lengkap }}</p>
                            <p class="text-xs text-gray-500">NIS: {{ $peminjaman->anggota->nis }}</p>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Data Buku</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                            <i class="ph ph-book-open"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 line-clamp-1">{{ $peminjaman->buku->judul }}</p>
                            <p class="text-xs text-gray-500">Kode/ISBN: {{ $peminjaman->buku->isbn }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Validasi -->
            <!-- Menambahkan x-data AlpineJS untuk melacak Pilihan Kondisi Buku secara real-time -->
            <form action="{{ route('peminjaman.prosesValidasi', $peminjaman->id) }}" method="POST" class="p-6 space-y-6" x-data="{ kondisi: 'Baik' }">
                @csrf

                <!-- Alert Keterlambatan -->
                @if($peminjaman->hari_terlambat > 0)
                    <div class="bg-red-50 border border-red-200 p-4 rounded-xl flex items-start gap-3">
                        <i class="ph ph-warning-circle text-red-600 text-2xl"></i>
                        <div>
                            <h4 class="font-bold text-red-800 text-sm">Terlambat {{ $peminjaman->hari_terlambat }} Hari!</h4>
                            <p class="text-sm text-red-700 mt-0.5">Siswa ini telah melewati batas waktu pengembalian. Sistem telah menghitung otomatis denda keterlambatan.</p>
                        </div>
                    </div>
                @else
                    <div class="bg-emerald-50 border border-emerald-200 p-4 rounded-xl flex items-start gap-3">
                        <i class="ph ph-check-circle text-emerald-600 text-2xl"></i>
                        <div>
                            <h4 class="font-bold text-emerald-800 text-sm">Tepat Waktu</h4>
                            <p class="text-sm text-emerald-700 mt-0.5">Siswa mengembalikan buku sesuai jadwal. Tidak ada denda keterlambatan.</p>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Input Total Denda -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Total Tagihan (Rp)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 font-bold">Rp</span>
                            </div>
                            <input type="number" name="denda" value="{{ $peminjaman->denda_berjalan }}" required min="0"
                                class="pl-12 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition font-bold text-gray-900 text-lg">
                        </div>
                        <p class="text-xs text-gray-500 mt-1.5">*Isi angka denda kerterlambatan / denda khusus di sini.</p>
                    </div>

                    <!-- Kondisi Buku -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kondisi Saat Dikembalikan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ph ph-exam text-gray-400 text-lg"></i>
                            </div>
                            <!-- x-model="kondisi" akan terhubung dengan Pop-up Peringatan di bawah -->
                            <select name="kondisi_buku" x-model="kondisi" required
                                class="pl-11 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition appearance-none cursor-pointer font-bold text-gray-700">
                                <option value="Baik">Bagus / Normal</option>
                                <option value="Rusak">Rusak (Halaman Robek/Kotor)</option>
                                <option value="Hilang (Belum Diganti)">Hilang (Siswa Belum Membawa Ganti)</option>
                                <option value="Hilang (Sudah Diganti)">Hilang (Sudah Diganti Buku Fisik Sama)</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="ph ph-caret-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ATURAN MUTLAK WARNING (Muncul Jika Hilang Belum Diganti ATAU Rusak) -->
                <div x-show="kondisi === 'Hilang (Belum Diganti)' || kondisi === 'Rusak'" x-transition x-cloak
                     class="bg-red-50 border-l-4 border-red-600 p-5 rounded-r-xl shadow-sm">
                    <div class="flex items-start gap-3">
                        <i class="ph ph-prohibit text-red-600 text-3xl animate-pulse"></i>
                        <div>
                            <h4 class="font-black text-red-800 text-sm uppercase tracking-widest mb-1">ATURAN MUTLAK: WAJIB GANTI BUKU!</h4>
                            <p class="text-sm text-red-700 leading-relaxed">
                                Buku yang hilang atau rusak parah <strong>tidak boleh diganti dengan uang tunai</strong>. Siswa diwajibkan mencari dan menyerahkan buku fisik dengan judul yang sama persis.
                            </p>
                            <p class="text-xs font-bold text-red-800 mt-2 bg-red-100 py-1.5 px-3 rounded-lg inline-block">
                                <i class="ph ph-info"></i> Stok buku ini tidak akan dikembalikan ke sistem sebelum siswa menyerahkan buku barunya.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Catatan Tambahan -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Catatan Kepala Perpus (Opsional)</label>
                    <textarea name="catatan" rows="3" placeholder="Tuliskan catatan kondisi buku, janji ganti buku, atau rincian kerusakan di sini..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm"></textarea>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <a href="{{ route('peminjaman.index') }}" class="px-6 py-3 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
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
