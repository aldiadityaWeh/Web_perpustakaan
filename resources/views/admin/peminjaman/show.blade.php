<x-admin-layout>
    <x-slot:title>
        Detail Peminjaman - Sistem Perpustakaan
    </x-slot:title>

    <div class="max-w-3xl mx-auto w-full pt-8 pb-10">
        <!-- Wadah Utama Minimalis (Tanpa shadow berlebihan) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 relative">

            <!-- Tombol Close (X) -->
            <a href="{{ route('peminjaman.index') }}" class="absolute top-8 right-8 text-gray-400 hover:text-gray-600 transition-colors" title="Tutup">
                <i class="ph ph-x text-xl font-bold"></i>
            </a>

            <h1 class="text-xl font-bold text-gray-800 mb-8">Detail Peminjaman</h1>

            <!-- GRID ATAS: Informasi Buku & Peminjam -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Kotak Buku -->
                <div>
                    <p class="text-[13px] text-gray-500 mb-2">Informasi Buku</p>
                    <div class="bg-[#f7faf9] rounded-lg p-4 h-full border border-gray-50">
                        <p class="text-[15px] font-semibold text-gray-800 mb-1">{{ $peminjaman->buku->judul ?? 'Buku Dihapus' }}</p>
                        <p class="text-[13px] text-gray-500 mb-2">ISBN: {{ $peminjaman->buku->isbn ?? '-' }}</p>

                        <!-- Kategori DDC -->
                        <span class="text-[11px] font-bold text-emerald-600">
                            {{ $peminjaman->buku->nama_kategori }}
                        </span>
                    </div>
                </div>

                <!-- Kotak Peminjam -->
                <div>
                    <p class="text-[13px] text-gray-500 mb-2">Informasi Peminjam</p>
                    <div class="bg-[#f7faf9] rounded-lg p-4 h-full border border-gray-50">
                        <p class="text-[15px] font-semibold text-gray-800 mb-1">{{ $peminjaman->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</p>
                        <p class="text-[13px] text-gray-500 mb-2">NIS: {{ $peminjaman->anggota->nis ?? '-' }}</p>

                        <!-- Kelas -->
                        <span class="text-[11px] font-bold text-blue-600">
                            Kelas {{ $peminjaman->anggota->kelas ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- GRID TENGAH: Waktu -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <p class="text-[13px] text-gray-500 mb-1">Tanggal Pinjam</p>
                    <p class="text-[15px] text-gray-800">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-[13px] text-gray-500 mb-1">Tanggal Kembali</p>
                    <p class="text-[15px] text-gray-800">{{ \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo)->format('d/m/Y') }}</p>
                </div>
            </div>

            <!-- STATUS -->
            <div class="mb-8">
                <p class="text-[13px] text-gray-500 mb-2">Status</p>
                @php $statusAkurat = strtolower(trim($peminjaman->status_aktual)); @endphp

                @if($statusAkurat == 'dipinjam')
                    <span class="inline-block px-4 py-1.5 bg-[#fdf4d6] text-[#8a611c] text-[12px] font-semibold rounded-full lowercase tracking-wide">
                        dipinjam
                    </span>
                @elseif($statusAkurat == 'terlambat')
                    <span class="inline-block px-4 py-1.5 bg-red-100 text-red-700 text-[12px] font-semibold rounded-full lowercase tracking-wide">
                        terlambat
                    </span>
                    <span class="inline-block ml-3 text-red-600 text-sm font-bold">Denda: Rp {{ number_format($peminjaman->denda_berjalan, 0, ',', '.') }}</span>
                @elseif($statusAkurat == 'dikembalikan' || $statusAkurat == 'sudah kembali')
                    <span class="inline-block px-4 py-1.5 bg-emerald-100 text-emerald-700 text-[12px] font-semibold rounded-full lowercase tracking-wide">
                        selesai
                    </span>
                @endif
            </div>

            <!-- CATATAN -->
            <div class="mb-8">
                <p class="text-[13px] text-gray-500 mb-1">Catatan</p>
                <p class="text-[15px] text-gray-800">{{ $peminjaman->catatan ?? 'Kondisi buku baik' }}</p>
            </div>

            <!-- PETUGAS -->
            <div>
                <p class="text-[13px] text-gray-500 mb-1">Petugas</p>
                <p class="text-[15px] text-gray-800">{{ Auth::user()->name ?? 'Administrator' }}</p>
            </div>

        </div>
    </div>
</x-admin-layout>
