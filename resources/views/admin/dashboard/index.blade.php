<x-admin-layout>
    @slot('title')
        Dashboard - Sistem Perpustakaan
    @endslot

    <div class="flex flex-col space-y-6">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-slate-100 transition-colors">Selamat Datang, {{ Auth::user()->name ?? 'Administrator' }} 👋</h1>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1 transition-colors">Ringkasan aktivitas perpustakaan Anda hari ini.</p>
            </div>
            <div class="bg-white dark:bg-slate-800 px-4 py-2.5 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 text-sm font-semibold text-gray-700 dark:text-slate-300 flex items-center gap-2 transition-all">
                <img src="{{ asset('images/kalender.png') }}" alt="Kalender" class="w-5 h-5 object-contain dark:opacity-80">
                <span id="currentDate">Memuat tanggal...</span>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">

            <!-- Total Buku -->
            <a href="{{ route('buku.index') }}" class="group bg-white dark:bg-slate-800 rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 dark:border-slate-700 flex items-center gap-4 hover:border-purple-300 dark:hover:border-purple-500/50 hover:shadow-md transition-all">
                <div class="h-12 w-12 sm:h-14 sm:w-14 rounded-2xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <img src="{{ asset('images/buku.png') }}" alt="Stok Buku" class="w-7 h-7 sm:w-8 sm:h-8 object-contain dark:opacity-90">
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Stok Tersedia</p>
                    <h3 class="text-xl sm:text-2xl font-black text-gray-800 dark:text-slate-100">{{ number_format($totalBuku, 0, ',', '.') }} <span class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Buku</span></h3>
                </div>
            </a>

            <!-- Anggota Aktif -->
            <a href="{{ route('anggota.index') }}" class="group bg-white dark:bg-slate-800 rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 dark:border-slate-700 flex items-center gap-4 hover:border-purple-300 dark:hover:border-purple-500/50 hover:shadow-md transition-all">
                <div class="h-12 w-12 sm:h-14 sm:w-14 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <img src="{{ asset('images/anggota.png') }}" alt="Anggota Aktif" class="w-7 h-7 sm:w-8 sm:h-8 object-contain dark:opacity-90">
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Anggota Aktif</p>
                    <h3 class="text-xl sm:text-2xl font-black text-gray-800 dark:text-slate-100">{{ number_format($anggotaAktif, 0, ',', '.') }} <span class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Siswa</span></h3>
                </div>
            </a>

            <!-- Sedang Dipinjam -->
            <a href="{{ route('pengembalian.index') }}" class="group bg-white dark:bg-slate-800 rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 dark:border-slate-700 flex items-center gap-4 hover:border-purple-300 dark:hover:border-purple-500/50 hover:shadow-md transition-all">
                <div class="h-12 w-12 sm:h-14 sm:w-14 rounded-2xl bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <img src="{{ asset('images/peminjaman.png') }}" alt="Sedang Dipinjam" class="w-7 h-7 sm:w-8 sm:h-8 object-contain dark:opacity-90">
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Dipinjam</p>
                    <h3 class="text-xl sm:text-2xl font-black text-gray-800 dark:text-slate-100">{{ number_format($sedangDipinjam, 0, ',', '.') }} <span class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Buku</span></h3>
                </div>
            </a>

            <!-- Jatuh Tempo -->
            <a href="{{ route('pengembalian.index') }}" class="group bg-white dark:bg-slate-800 rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 dark:border-slate-700 flex items-center gap-4 hover:border-red-300 dark:hover:border-red-500/50 hover:shadow-md transition-all">
                <div class="h-12 w-12 sm:h-14 sm:w-14 rounded-2xl bg-red-50 dark:bg-red-500/10 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <img src="{{ asset('images/alert.png') }}" alt="Jatuh Tempo" class="w-7 h-7 sm:w-8 sm:h-8 object-contain dark:opacity-90">
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Jatuh Tempo</p>
                    <h3 class="text-xl sm:text-2xl font-black text-gray-800 dark:text-slate-100">{{ number_format($jatuhTempo, 0, ',', '.') }} <span class="text-xs sm:text-sm font-medium text-gray-500 dark:text-slate-400">Transaksi</span></h3>
                </div>
            </a>
        </div>

        <!-- Bagian Bawah Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Aksi Cepat -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-5 sm:p-6 flex flex-col transition-colors">
                <h3 class="font-bold text-gray-800 dark:text-slate-100 text-base mb-4 flex items-center gap-2">
                    <i class="ph ph-lightning text-purple-600 dark:text-purple-400"></i> Aksi Cepat
                </h3>

                <!-- Tombol Kiosk -->
                <a href="{{ route('kiosk.index') }}" target="_blank" class="group w-full mb-4 flex items-center justify-center gap-2 bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-100 dark:hover:bg-blue-500/20 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-500/20 py-3 rounded-xl text-sm font-bold transition-all shadow-sm">
                    <i class="ph ph-desktop text-xl group-hover:scale-110 transition-transform"></i>
                    Buka Kiosk
                </a>

                <!-- 4 Tombol Menu -->
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('peminjaman.create') }}" class="group flex flex-col items-center gap-2 p-3 bg-purple-50 dark:bg-purple-500/10 hover:bg-purple-100 dark:hover:bg-purple-500/20 text-purple-700 dark:text-purple-400 rounded-xl border border-purple-100 dark:border-purple-500/20 transition-all text-center">
                        <img src="{{ asset('images/peminjaman.png') }}" alt="Pinjam" class="w-7 h-7 object-contain group-hover:scale-110 transition-transform dark:opacity-90">
                        <span class="text-xs font-semibold">Peminjaman Baru</span>
                    </a>

                    <a href="{{ route('pengembalian.index') }}" class="group flex flex-col items-center gap-2 p-3 bg-indigo-50 dark:bg-indigo-500/10 hover:bg-indigo-100 dark:hover:bg-indigo-500/20 text-indigo-700 dark:text-indigo-400 rounded-xl border border-indigo-100 dark:border-indigo-500/20 transition-all text-center">
                        <img src="{{ asset('images/kembali.png') }}" alt="Kembali" class="w-7 h-7 object-contain group-hover:scale-110 transition-transform dark:opacity-90">
                        <span class="text-xs font-semibold">Pengembalian</span>
                    </a>

                    <a href="{{ route('buku.create') }}" class="group flex flex-col items-center gap-2 p-3 bg-emerald-50 dark:bg-emerald-500/10 hover:bg-emerald-100 dark:hover:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl border border-emerald-100 dark:border-emerald-500/20 transition-all text-center">
                        <img src="{{ asset('images/buku.png') }}" alt="Buku" class="w-7 h-7 object-contain group-hover:scale-110 transition-transform dark:opacity-90">
                        <span class="text-xs font-semibold">Tambah Buku</span>
                    </a>

                    <a href="{{ route('anggota.create') }}" class="group flex flex-col items-center gap-2 p-3 bg-amber-50 dark:bg-amber-500/10 hover:bg-amber-100 dark:hover:bg-amber-500/20 text-amber-700 dark:text-amber-400 rounded-xl border border-amber-100 dark:border-amber-500/20 transition-all text-center">
                        <img src="{{ asset('images/anggota-plus.png') }}" alt="Anggota" class="w-7 h-7 object-contain group-hover:scale-110 transition-transform dark:opacity-90">
                        <span class="text-xs font-semibold">Tambah Anggota</span>
                    </a>
                </div>
            </div>

            <!-- Perlu Perhatian -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col lg:col-span-2 overflow-hidden transition-colors">

                <div class="p-5 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-800/50">
                    <div>
                        <h3 class="font-bold text-gray-800 dark:text-slate-100 text-base">Perlu Perhatian</h3>
                        <p class="text-xs text-gray-500 dark:text-slate-400">Buku yang jatuh tempo hari ini atau terlambat</p>
                    </div>
                    <a href="{{ route('pengembalian.index') }}" class="text-xs font-bold text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-500/10 hover:bg-purple-100 dark:hover:bg-purple-500/20 px-3 py-1.5 rounded-lg transition-colors">Lihat Semua</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[500px]">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-slate-700 text-gray-400 dark:text-slate-500 text-[10px] font-bold uppercase tracking-wider bg-white dark:bg-slate-800">
                                <th class="py-3.5 px-5">Peminjam</th>
                                <th class="py-3.5 px-5">Buku</th>
                                <th class="py-3.5 px-5">Batas Kembali</th>
                                <th class="py-3.5 px-5 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm bg-white dark:bg-slate-800">
                            @forelse($perluPerhatian as $trx)
                                @php
                                    $tglJatuhTempo = \Carbon\Carbon::parse($trx->tanggal_jatuh_tempo)->startOfDay();
                                    $isTerlambat = $hariIni->greaterThan($tglJatuhTempo);
                                @endphp
                                <tr class="border-b last:border-0 border-gray-50 dark:border-slate-700/50 hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition-colors">
                                    <td class="py-3.5 px-5">
                                        <p class="font-bold text-gray-800 dark:text-slate-200">{{ $trx->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</p>
                                    </td>
                                    <td class="py-3.5 px-5">
                                        <p class="font-bold text-gray-800 dark:text-slate-200 line-clamp-1" title="{{ $trx->buku->judul ?? 'Buku Dihapus' }}">
                                            {{ $trx->buku->judul ?? 'Buku Dihapus' }}
                                        </p>
                                    </td>
                                    <td class="py-3.5 px-5 text-gray-600 dark:text-slate-400 font-medium text-xs">
                                        {{ \Carbon\Carbon::parse($trx->tanggal_jatuh_tempo)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="py-3.5 px-5 text-right">
                                        @if($isTerlambat)
                                            <span class="inline-block px-2.5 py-1 bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 text-[10px] font-bold rounded-lg uppercase tracking-wider">Terlambat</span>
                                        @else
                                            <span class="inline-block px-2.5 py-1 bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 text-[10px] font-bold rounded-lg uppercase tracking-wider">Hari Ini</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400 dark:text-slate-500">
                                            <i class="ph ph-check-circle text-4xl mb-2 text-emerald-400 dark:text-emerald-500/70 block leading-none"></i>
                                            <p class="text-sm font-medium">Semua aman! Tidak ada transaksi jatuh tempo.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Script Jam Realtime -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const today = new Date().toLocaleDateString('id-ID', dateOptions);
            const dateElement = document.getElementById('currentDate');
            if (dateElement) {
                dateElement.textContent = today;
            }
        });
    </script>
</x-admin-layout>
