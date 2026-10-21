<x-admin-layout>
    <x-slot:title>
        Detail Anggota - Sistem Perpustakaan
    </x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-slate-100 transition-colors">Informasi Detail Anggota</h1>
            <p class="text-sm text-gray-500 dark:text-slate-400 mt-1 transition-colors">Melihat kelengkapan data siswa</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('anggota.index') }}" class="inline-flex items-center gap-2 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-300 px-4 py-2 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                <i class="ph ph-arrow-left text-lg"></i>
                Kembali
            </a>

            <!-- TOMBOL DOWNLOAD KARTU DIPERBARUI (MENGIRIMKAN NAMA FILE KE JS) -->
            <button type="button" onclick="downloadAsImage('kartu-anggota-design', 'Kartu_Anggota_{{ $anggota->nis }}.png')" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 cursor-pointer">
                <i class="ph ph-download-simple text-lg"></i>
                Download Kartu
            </button>

            <a href="{{ route('anggota.edit', $anggota->id) }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                <i class="ph ph-pencil-simple text-lg"></i>
                Edit Anggota
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden max-w-5xl transition-colors">
        <div class="p-6 sm:p-8 flex flex-col md:flex-row gap-8">

            <!-- Bagian Kiri: Avatar Ilustrasi -->
            <div class="w-full md:w-1/3 flex flex-col items-center">
                <div class="w-48 h-48 rounded-full bg-gray-50 dark:bg-slate-900 border-4 border-white dark:border-slate-800 shadow-md flex items-center justify-center text-gray-400 dark:text-slate-500 mb-6 relative transition-colors">
                    <!-- Icon disesuaikan dengan jenis kelamin -->
                    @if($anggota->jenis_kelamin == 'L')
                        <i class="ph ph-student text-7xl text-blue-500 dark:text-blue-400"></i>
                    @else
                        <i class="ph ph-student text-7xl text-pink-500 dark:text-pink-400"></i>
                    @endif

                    <!-- Status Badge Absolute -->
                    <div class="absolute bottom-2 right-2">
                        @if($anggota->status == 'Aktif')
                            <span class="flex items-center justify-center w-8 h-8 bg-emerald-500 text-white rounded-full border-2 border-white dark:border-slate-800" title="Status Aktif">
                                <i class="ph ph-check-circle text-lg"></i>
                            </span>
                        @else
                            <span class="flex items-center justify-center w-8 h-8 bg-red-500 text-white rounded-full border-2 border-white dark:border-slate-800" title="Status Tidak Aktif">
                                <i class="ph ph-x-circle text-lg"></i>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="text-center w-full max-w-[240px]">
                    <div class="bg-purple-50 dark:bg-purple-500/10 rounded-xl p-4 border border-purple-100 dark:border-purple-500/20 transition-colors">
                        <span class="text-sm text-purple-700 dark:text-purple-400 font-medium block mb-1">Total Peminjaman</span>
                        <span class="text-2xl font-black text-purple-800 dark:text-purple-300">
                            <!-- Hitung jumlah peminjaman secara dinamis -->
                            {{ $anggota->peminjamans->count() }} <span class="text-sm font-normal text-purple-600 dark:text-purple-400">Kali</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Bagian Kanan: Informasi Detail -->
            <div class="w-full md:w-2/3 flex flex-col gap-6">

                <div class="border-b border-gray-100 dark:border-slate-700 pb-4 transition-colors">
                    <h2 class="text-3xl font-extrabold text-gray-800 dark:text-slate-100 leading-tight mb-2">{{ $anggota->nama_lengkap }}</h2>
                    <p class="text-lg text-gray-600 dark:text-slate-400 flex items-center gap-2">
                        <i class="ph ph-identification-card text-purple-600 dark:text-purple-400"></i> NIS: {{ $anggota->nis }}
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                    <div>
                        <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Kelas Saat Ini</p>
                        <p class="font-medium text-gray-800 dark:text-slate-200 text-lg border-l-2 border-purple-500 pl-2">Kelas {{ $anggota->kelas }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Jenis Kelamin</p>
                        <p class="font-medium text-gray-800 dark:text-slate-200 flex items-center gap-2">
                            @if($anggota->jenis_kelamin == 'L')
                                <i class="ph ph-gender-male text-blue-500 dark:text-blue-400 text-xl"></i> Laki-laki
                            @else
                                <i class="ph ph-gender-female text-pink-500 dark:text-pink-400 text-xl"></i> Perempuan
                            @endif
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Alamat Tempat Tinggal</p>
                        <p class="font-medium text-gray-800 dark:text-slate-300 leading-relaxed">
                            {{ $anggota->alamat ?: 'Tidak ada informasi alamat yang dicantumkan.' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Status Keanggotaan</p>
                        @if($anggota->status == 'Aktif')
                            <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-[10px] font-bold rounded-lg uppercase tracking-wider inline-block mt-1 transition-colors">Siswa Aktif</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 text-[10px] font-bold rounded-lg uppercase tracking-wider inline-block mt-1 transition-colors">Sudah Lulus / Pindah</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Terdaftar Sejak</p>
                        <p class="font-medium text-gray-600 dark:text-slate-400 text-sm">{{ $anggota->created_at->format('d F Y') }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- TABEL RIWAYAT PEMINJAMAN SISWA -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden max-w-5xl mt-6 transition-colors">
        <div class="p-6 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between bg-gray-50/50 dark:bg-slate-800/50">
            <div>
                <h3 class="font-bold text-gray-800 dark:text-slate-100 text-lg">Riwayat Peminjaman</h3>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Daftar buku yang pernah dan sedang dipinjam oleh siswa ini</p>
            </div>
            <div class="h-10 w-10 rounded-xl bg-purple-100 dark:bg-purple-500/20 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xl transition-colors">
                <i class="ph ph-handshake"></i>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead class="bg-white dark:bg-slate-800 border-b border-gray-100 dark:border-slate-700 transition-colors">
                    <tr class="text-gray-500 dark:text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                        <th class="py-4 px-6 w-16 text-center">NO</th>
                        <th class="py-4 px-6">JUDUL BUKU</th>
                        <th class="py-4 px-6">TGL PINJAM</th>
                        <th class="py-4 px-6">TGL KEMBALI</th>
                        <th class="py-4 px-6">STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-slate-700/50">
                    @forelse($anggota->peminjamans as $pinjam)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition-colors text-sm">
                        <td class="py-4 px-6 text-gray-600 dark:text-slate-400 font-medium text-center">{{ $loop->iteration }}</td>
                        <td class="py-4 px-6 font-bold text-gray-800 dark:text-slate-200">
                            {{ $pinjam->buku->judul ?? 'Buku telah dihapus' }}
                        </td>
                        <td class="py-4 px-6 text-gray-600 dark:text-slate-400">
                            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}
                        </td>
                        <td class="py-4 px-6 text-gray-600 dark:text-slate-400">
                            @if($pinjam->tanggal_kembali)
                                {{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d M Y') }}
                            @else
                                <span class="text-gray-400 dark:text-slate-500 italic">Belum kembali</span><br>
                                <span class="text-[10px] font-bold text-red-500 dark:text-red-400">Batas: {{ \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->format('d M Y') }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @if($pinjam->status == 'dipinjam')
                                <span class="px-3 py-1 bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 text-[10px] font-bold rounded-lg uppercase tracking-wider transition-colors">Dipinjam</span>
                            @elseif($pinjam->status == 'dikembalikan')
                                <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-[10px] font-bold rounded-lg uppercase tracking-wider transition-colors">Selesai</span>
                            @elseif($pinjam->status == 'terlambat')
                                <span class="px-3 py-1 bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 text-[10px] font-bold rounded-lg uppercase tracking-wider transition-colors">Terlambat</span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300 text-[10px] font-bold rounded-lg uppercase tracking-wider transition-colors">{{ $pinjam->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400 dark:text-slate-500">
                                <i class="ph ph-receipt text-4xl mb-3 text-gray-300 dark:text-slate-600"></i>
                                <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Siswa ini belum pernah meminjam buku</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- AREA TERSEMBUNYI UNTUK RENDER DOWNLOAD PNG -->
    <!-- Note: TIDAK ADA KELAS DARK MODE DI SINI agar hasil cetak selalu terang -->
    <!-- ========================================== -->
     <div style="position: absolute; left: -9999px; top: 0; z-index: -10;">
        <div id="kartu-anggota-design" class="w-[340px] bg-white rounded-xl overflow-hidden border border-gray-200">
            <!-- Header Kartu -->
            <div class="bg-gradient-to-r from-purple-700 to-purple-500 p-4 text-center border-b-4 border-yellow-400">
                <h1 class="text-white font-black text-lg uppercase tracking-wider leading-none">Kartu Anggota</h1>
                <p class="text-purple-100 text-[10px] uppercase font-bold mt-1 tracking-widest">Perpustakaan Sekolah</p>
            </div>

            <!-- Body Kartu -->
            <div class="p-5 relative bg-white">
                <div class="space-y-3 z-10 relative">
                    <div>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Nama Lengkap</p>
                        <p class="text-sm font-black text-gray-800 leading-tight uppercase">{{ $anggota->nama_lengkap }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">NIS / NIP</p>
                            <p class="text-xs font-bold text-gray-800">{{ $anggota->nis }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Kelas/Status</p>
                            <p class="text-xs font-bold text-gray-800">{{ $anggota->kelas ?? 'Guru/Staf' }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex flex-col items-center justify-center bg-purple-50 p-3 rounded-lg border border-purple-100 shadow-inner">
                    <p class="text-[10px] text-purple-400 font-bold uppercase tracking-widest mb-0.5">ID / Sandi Kiosk</p>
                    <p class="text-2xl font-black text-purple-700 tracking-widest">{{ $anggota->nis }}</p>
                </div>
            </div>

            <!-- Footer Kartu -->
            <div class="bg-gray-800 text-center py-1.5">
                <p class="text-[8px] text-gray-300">Harap bawa kartu ini setiap kali meminjam buku di Kiosk.</p>
            </div>
        </div>
    </div>

    <!-- SCRIPT UNTUK DOWNLOAD MENJADI GAMBAR PNG -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="{{ asset('js/cetak-gambar.js') }}"></script>
</x-admin-layout>
