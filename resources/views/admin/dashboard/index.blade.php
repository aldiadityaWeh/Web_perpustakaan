<x-admin-layout>
    @slot('title')
        Dashboard - Sistem Perpustakaan
    @endslot

    <div class="flex flex-col h-full min-h-full">

        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name ?? 'Administrator' }} 👋</h1>
                <p class="text-sm text-gray-500 mt-1">Berikut adalah ringkasan aktivitas perpustakaan Anda hari ini.</p>
            </div>
            <div class="bg-white px-4 py-2.5 rounded-xl shadow-sm border border-gray-100 text-sm font-semibold text-gray-700 flex items-center gap-2 w-fit transform hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                <img src="{{ asset('images/kalender.png') }}" alt="Kalender" class="w-5 h-5 object-contain">
                <span id="currentDate">Memuat tanggal...</span>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Buku -->
            <a href="{{ route('buku.index') }}" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:border-purple-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="h-14 w-14 rounded-2xl bg-blue-50 flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-blue-100 transition-all duration-300 overflow-hidden">
                    <!-- Ganti 'ikon-buku.png' dengan nama file Anda -->
                    <img src="{{ asset('images/buku.png') }}" alt="Stok Buku" class="w-8 h-8 object-contain">
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Stok Tersedia</p>
                    <h3 class="text-2xl font-extrabold text-gray-800">{{ number_format($totalBuku, 0, ',', '.') }} <span class="text-sm font-normal text-gray-500">Buku</span></h3>
                </div>
            </a>

            <!-- Anggota Aktif -->
            <a href="{{ route('anggota.index') }}" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:border-purple-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="h-14 w-14 rounded-2xl bg-emerald-50 flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-emerald-100 transition-all duration-300 overflow-hidden">
                    <!-- Ganti 'ikon-anggota.png' dengan nama file Anda -->
                    <img src="{{ asset('images/anggota.png') }}" alt="Anggota Aktif" class="w-8 h-8 object-contain">
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Anggota Aktif</p>
                    <h3 class="text-2xl font-extrabold text-gray-800">{{ number_format($anggotaAktif, 0, ',', '.') }} <span class="text-sm font-normal text-gray-500">Siswa</span></h3>
                </div>
            </a>

            <!-- Sedang Dipinjam -->
            <a href="{{ route('pengembalian.index') }}" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:border-purple-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="h-14 w-14 rounded-2xl bg-amber-50 flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-amber-100 transition-all duration-300 overflow-hidden">
                    <!-- Ganti 'ikon-pinjam.png' dengan nama file Anda -->
                    <img src="{{ asset('images/peminjaman.png') }}" alt="Sedang Dipinjam" class="w-8 h-8 object-contain">
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Sedang Dipinjam</p>
                    <h3 class="text-2xl font-extrabold text-gray-800">{{ number_format($sedangDipinjam, 0, ',', '.') }} <span class="text-sm font-normal text-gray-500">Buku</span></h3>
                </div>
            </a>

            <!-- Jatuh Tempo -->
            <a href="{{ route('pengembalian.index') }}" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:border-red-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="h-14 w-14 rounded-2xl bg-red-50 flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-red-100 transition-all duration-300 overflow-hidden">
                    <!-- Ganti 'ikon-alert.png' dengan nama file Anda -->
                    <img src="{{ asset('images/alert.png') }}" alt="Jatuh Tempo" class="w-8 h-8 object-contain">
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Jatuh Tempo</p>
                    <h3 class="text-2xl font-extrabold text-gray-800">{{ number_format($jatuhTempo, 0, ',', '.') }} <span class="text-sm font-normal text-gray-500">Transaksi</span></h3>
                </div>
            </a>
        </div>

        <!-- Bagian Bawah -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <!-- Aksi Cepat -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col">
                <h3 class="font-bold text-gray-800 text-base mb-4 flex items-center gap-2">
                    <i class="ph ph-lightning text-purple-600"></i> Aksi Cepat
                </h3>
                <div class="grid grid-cols-2 gap-3">

                    <!-- Tombol Peminjaman Baru -->
                    <a href="{{ route('peminjaman.create') }}" class="flex flex-col items-center justify-center gap-2 p-4 bg-purple-50/50 hover:bg-purple-100 text-purple-700 rounded-xl transition-colors text-center border border-purple-100/50 group">
                        <!-- Ganti nama file gambar di bawah -->
                        <img src="{{ asset('images/peminjaman.png') }}" alt="Pinjam" class="w-8 h-8 object-contain group-hover:scale-110 transition-transform duration-300">
                        <span class="text-xs font-semibold">Peminjaman Baru</span>
                    </a>

                    <!-- Tombol Pengembalian -->
                    <a href="{{ route('pengembalian.index') }}" class="flex flex-col items-center justify-center gap-2 p-4 bg-blue-50/50 hover:bg-blue-100 text-blue-700 rounded-xl transition-colors text-center border border-blue-100/50 group">
                        <!-- Ganti nama file gambar di bawah -->
                        <img src="{{ asset('images/kembali.png') }}" alt="Kembali" class="w-8 h-8 object-contain group-hover:scale-110 transition-transform duration-300">
                        <span class="text-xs font-semibold">Pengembalian</span>
                    </a>

                    <!-- Tombol Tambah Buku -->
                    <a href="{{ route('buku.create') }}" class="flex flex-col items-center justify-center gap-2 p-4 bg-emerald-50/50 hover:bg-emerald-100 text-emerald-700 rounded-xl transition-colors text-center border border-emerald-100/50 group">
                        <!-- Ganti nama file gambar di bawah -->
                        <img src="{{ asset('images/buku.png') }}" alt="Buku" class="w-8 h-8 object-contain group-hover:scale-110 transition-transform duration-300">
                        <span class="text-xs font-semibold">Tambah Buku</span>
                    </a>

                    <!-- Tombol Tambah Anggota -->
                    <a href="{{ route('anggota.create') }}" class="flex flex-col items-center justify-center gap-2 p-4 bg-amber-50/50 hover:bg-amber-100 text-amber-700 rounded-xl transition-colors text-center border border-amber-100/50 group">
                        <!-- Ganti nama file gambar di bawah -->
                        <img src="{{ asset('images/anggota-plus.png') }}" alt="Anggota" class="w-8 h-8 object-contain group-hover:scale-110 transition-transform duration-300">
                        <span class="text-xs font-semibold">Tambah Anggota</span>
                    </a>

                </div>
            </div>

            <!-- Perlu Perhatian (Tidak ada perubahan gambar, logika tetap aman) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col lg:col-span-2 overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
                    <div>
                        <h3 class="font-bold text-gray-800 text-base">Perlu Perhatian</h3>
                        <p class="text-xs text-gray-500">Buku yang harus dikembalikan hari ini atau terlambat</p>
                    </div>
                    <a href="{{ route('pengembalian.index') }}" class="text-xs font-semibold text-purple-600 hover:text-purple-700 bg-purple-50 px-3 py-1.5 rounded-lg transition-colors">Lihat Semua</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-gray-400 text-[10px] font-bold uppercase tracking-wider">
                                <th class="py-3 px-5">Peminjam</th>
                                <th class="py-3 px-5">Buku</th>
                                <th class="py-3 px-5">Batas Kembali</th>
                                <th class="py-3 px-5 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($perluPerhatian as $trx)
                                @php
                                    $tglJatuhTempo = \Carbon\Carbon::parse($trx->tanggal_jatuh_tempo)->startOfDay();
                                    $isTerlambat = $hariIni->greaterThan($tglJatuhTempo);
                                @endphp
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3 px-5">
                                        <p class="font-bold text-gray-800">{{ $trx->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</p>
                                    </td>
                                    <td class="py-3 px-5">
                                        <p class="font-bold text-gray-800 line-clamp-1" title="{{ $trx->buku->judul ?? 'Buku Dihapus' }}">
                                            {{ $trx->buku->judul ?? 'Buku Dihapus' }}
                                        </p>
                                    </td>
                                    <td class="py-3 px-5 text-gray-600 font-medium">
                                        {{ \Carbon\Carbon::parse($trx->tanggal_jatuh_tempo)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="py-3 px-5 text-right">
                                        @if($isTerlambat)
                                            <span class="inline-block px-2.5 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded-lg uppercase tracking-wider shadow-sm">Terlambat</span>
                                        @else
                                            <span class="inline-block px-2.5 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-lg uppercase tracking-wider shadow-sm">Hari Ini</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <i class="ph ph-check-circle text-4xl mb-2 text-emerald-400 block leading-none"></i>
                                            <p class="text-sm font-medium text-gray-500">Semua aman! Tidak ada transaksi jatuh tempo.</p>
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
            document.getElementById('currentDate').textContent = today;
        });
    </script>
</x-admin-layout>
