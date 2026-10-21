<x-admin-layout>
    <x-slot:title>
        Detail Peminjaman - Sistem Perpustakaan
    </x-slot:title>

    <div class="max-w-3xl mx-auto w-full pt-8 pb-10">
        <!-- Wadah Utama Minimalis dengan Transisi Dark Mode -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 p-8 relative transition-colors">

            <!-- Tombol Close (X) -->
            <a href="{{ route('peminjaman.index') }}" class="absolute top-6 right-6 p-2 text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-full transition-all focus:outline-none" title="Tutup">
                <i class="ph ph-x text-xl font-bold"></i>
            </a>

            <!-- Judul Halaman -->
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-full bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0">
                    <i class="ph ph-handshake text-xl font-bold"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-slate-100 transition-colors">Detail Transaksi</h1>
            </div>

            <!-- GRID ATAS: Informasi Buku & Peminjam -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Kotak Buku -->
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-2">Informasi Buku</p>
                    <div class="bg-gray-50 dark:bg-slate-900/50 rounded-xl p-5 h-full border border-gray-100 dark:border-slate-700/50 transition-colors">
                        <p class="text-base font-bold text-gray-800 dark:text-slate-200 mb-1 transition-colors">{{ $peminjaman->buku->judul ?? 'Buku Dihapus' }}</p>
                        <p class="text-sm text-gray-500 dark:text-slate-400 mb-3 font-mono transition-colors">ISBN: {{ $peminjaman->buku->isbn ?? '-' }}</p>

                        <!-- Kategori DDC -->
                        <span class="inline-block px-2.5 py-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-md text-[11px] font-bold text-emerald-600 dark:text-emerald-400 transition-colors">
                            <i class="ph ph-bookmark-simple"></i> {{ $peminjaman->buku->nama_kategori ?? 'Kategori Umum' }}
                        </span>
                    </div>
                </div>

                <!-- Kotak Peminjam -->
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-2">Informasi Peminjam</p>
                    <div class="bg-gray-50 dark:bg-slate-900/50 rounded-xl p-5 h-full border border-gray-100 dark:border-slate-700/50 transition-colors">
                        <p class="text-base font-bold text-gray-800 dark:text-slate-200 mb-1 transition-colors">{{ $peminjaman->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</p>
                        <p class="text-sm text-gray-500 dark:text-slate-400 mb-3 font-mono transition-colors">NIS: {{ $peminjaman->anggota->nis ?? '-' }}</p>

                        <!-- Kelas -->
                        <span class="inline-block px-2.5 py-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-md text-[11px] font-bold text-blue-600 dark:text-blue-400 transition-colors">
                            <i class="ph ph-student"></i> Kelas {{ $peminjaman->anggota->kelas ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- GRID TENGAH: Waktu -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 p-5 bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-xl shadow-sm transition-colors">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-50 dark:bg-blue-500/10 text-blue-500 flex items-center justify-center shrink-0">
                        <i class="ph ph-calendar-arrow-up text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">Tanggal Pinjam</p>
                        <p class="text-sm font-bold text-gray-800 dark:text-slate-200 transition-colors">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-amber-50 dark:bg-amber-500/10 text-amber-500 flex items-center justify-center shrink-0">
                        <i class="ph ph-calendar-arrow-down text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">Batas Kembali</p>
                        <p class="text-sm font-bold text-gray-800 dark:text-slate-200 transition-colors">{{ \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- STATUS -->
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-2">Status Saat Ini</p>
                    @php $statusAkurat = strtolower(trim($peminjaman->status_aktual)); @endphp

                    @if($statusAkurat == 'dipinjam')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20 text-xs font-bold rounded-lg uppercase tracking-wider transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 dark:bg-amber-400"></span> Dipinjam
                        </span>
                    @elseif($statusAkurat == 'terlambat')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-500/20 text-xs font-bold rounded-lg uppercase tracking-wider transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 dark:bg-red-400 animate-pulse"></span> Terlambat
                        </span>
                        <p class="mt-2 text-xs font-bold text-red-600 dark:text-red-400 transition-colors">Denda: Rp {{ number_format($peminjaman->denda_berjalan, 0, ',', '.') }}</p>
                    @elseif($statusAkurat == 'dikembalikan' || $statusAkurat == 'sudah kembali')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20 text-xs font-bold rounded-lg uppercase tracking-wider transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400"></span> Selesai
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300 border border-gray-200 dark:border-slate-600 text-xs font-bold rounded-lg uppercase tracking-wider transition-colors">
                            {{ $peminjaman->status_aktual }}
                        </span>
                    @endif
                </div>

                <!-- PETUGAS -->
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-2">Petugas Pendaftar</p>
                    <p class="text-sm font-bold text-gray-800 dark:text-slate-200 flex items-center gap-2 transition-colors">
                        <i class="ph ph-user-circle text-purple-500 text-lg"></i> {{ Auth::user()->name ?? 'Administrator' }}
                    </p>
                </div>

                <!-- CATATAN -->
                <div class="sm:col-span-3 pt-4 border-t border-gray-100 dark:border-slate-700 transition-colors">
                    <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-2">Catatan Tambahan</p>
                    <p class="text-sm font-medium text-gray-700 dark:text-slate-300 leading-relaxed transition-colors">
                        {{ $peminjaman->catatan ?? 'Kondisi buku baik, tidak ada catatan khusus yang ditinggalkan.' }}
                    </p>
                </div>
            </div>

            <!-- Tombol Tambahan Jika Belum Selesai -->
            @if($statusAkurat == 'dipinjam' || $statusAkurat == 'terlambat')
                <div class="mt-8 flex justify-end">
                    <a href="{{ route('peminjaman.validasi', $peminjaman->id) }}" class="px-6 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold rounded-xl transition-colors shadow-sm flex items-center gap-2">
                        Validasi Pengembalian <i class="ph ph-arrow-right"></i>
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-admin-layout>
