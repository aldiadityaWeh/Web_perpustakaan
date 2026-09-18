<x-admin-layout>
    <x-slot:title>
        Data Peminjaman - Sistem Perpustakaan
    </x-slot:title>

    <!-- Wrapper utama dibuat flex-col agar footer (mt-auto) terdorong ke bawah -->
    <div class="flex flex-col flex-1 min-h-[85vh] w-full">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Data Peminjaman</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola transaksi peminjaman buku</p>
            </div>

             <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-sm focus:outline-none shrink-0">
                <i class="ph ph-plus font-bold"></i>
                Tambah Peminjaman
            </a>
        </div>

        <!-- PENCARIAN (Desain Kartu Putih Sesuai Gambar) -->
        <div class="mb-6 w-full bg-white p-3.5 rounded-xl border border-gray-100 shadow-sm">
            <form action="{{ route('peminjaman.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full">
                <!-- Kotak Input -->
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="ph ph-magnifying-glass text-gray-400 text-lg"></i>
                    </div>
                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}" autocomplete="off" placeholder="Ketik Nama Siswa, NIS, atau Kelas..."
                    class="pl-10 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-700 bg-white">
                </div>

                <!-- Tombol Cari Data -->
                <button type="submit" class="w-full sm:w-auto bg-purple-600 hover:bg-purple-700 text-white px-8 py-2.5 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center whitespace-nowrap shrink-0">
                    Cari Data
                </button>
            </form>
        </div>

        <!-- WADAH TABEL -->
       <div id="table-container" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">

            <!-- Notifikasi Berhasil -->
            @if(session('success'))
                <div class="bg-emerald-50 p-4 text-emerald-700 text-sm font-medium border-b border-emerald-100">
                    <i class="ph ph-check-circle text-lg align-middle mr-1"></i> {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead class="bg-purple-50/50 border-b border-gray-200">
                        <tr class="text-gray-500 text-xs font-bold uppercase tracking-wider">
                            <th class="py-4 px-6">Judul Buku</th>
                            <th class="py-4 px-6">Peminjam</th>
                            <th class="py-4 px-6 text-center">Tanggal Pinjam</th>
                            <th class="py-4 px-6 text-center">Tanggal Kembali</th>
                            <th class="py-4 px-6 text-center">Status</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($peminjamans as $pinjam)
                        @php
                            $statusAkurat = strtolower(trim($pinjam->status_aktual));
                        @endphp

                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors text-sm">
                            <!-- Kolom Judul Buku -->
                            <td class="py-4 px-6">
                                <span class="font-semibold text-gray-800 block">{{ $pinjam->buku->judul ?? 'Buku Dihapus' }}</span>
                                <span class="text-xs text-gray-500 mt-0.5 block">ISBN: {{ $pinjam->buku->isbn ?? '-' }}</span>
                            </td>

                            <!-- Kolom Peminjam -->
                            <td class="py-4 px-6">
                                <span class="font-semibold text-gray-800 block">{{ $pinjam->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</span>
                                <span class="text-xs text-gray-500 mt-0.5 block">NIS: {{ $pinjam->anggota->nis ?? '-' }}</span>
                            </td>

                            <!-- Kolom Tanggal Pinjam -->
                            <td class="py-4 px-6 text-center text-gray-600">
                                {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') }}
                            </td>

                            <!-- Kolom Tanggal Kembali & Denda -->
                            <td class="py-4 px-6 text-center text-gray-600">
                                {{ \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->format('d/m/Y') }}
                                @if($statusAkurat == 'terlambat')
                                    <span class="block text-red-600 text-[10px] mt-1 font-bold">Telat {{ $pinjam->hari_terlambat }} Hari</span>
                                @endif
                            </td>

                            <!-- Kolom Status -->
                            <td class="py-4 px-6 text-center">
                                <div class="flex flex-col items-center justify-center gap-1">
                                    @if($statusAkurat == 'dipinjam')
                                        <span class="inline-block px-4 py-1.5 bg-[#fdf4d6] text-[#8a611c] text-xs font-semibold rounded-full lowercase tracking-wide">
                                            dipinjam
                                        </span>
                                    @elseif($statusAkurat == 'terlambat')
                                        <span class="inline-block px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-full lowercase tracking-wide">
                                            terlambat
                                        </span>
                                        <span class="text-[10px] font-bold text-red-600">
                                            Denda: Rp {{ number_format($pinjam->denda_berjalan, 0, ',', '.') }}
                                        </span>
                                    @elseif($statusAkurat == 'dikembalikan' || $statusAkurat == 'sudah kembali')
                                        <span class="inline-block px-4 py-1.5 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full lowercase tracking-wide">
                                            selesai
                                        </span>
                                    @else
                                        <span class="inline-block px-4 py-1.5 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full lowercase tracking-wide">
                                            {{ $pinjam->status_aktual }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Kolom Aksi -->
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    @if($statusAkurat == 'dipinjam' || $statusAkurat == 'terlambat')
                                        <a href="{{ route('peminjaman.validasi', $pinjam->id) }}" class="text-emerald-500 hover:text-emerald-700 transition-colors" title="Validasi Pengembalian">
                                            <i class="ph ph-arrow-counter-clockwise text-xl font-bold"></i>
                                        </a>
                                    @else
                                        <span class="w-5"></span>
                                    @endif

                                    <a href="{{ route('peminjaman.show', $pinjam->id) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Lihat Detail">
                                        <i class="ph ph-eye text-xl font-bold"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-500 text-sm">
                                Belum ada data peminjaman buku.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div id="area-pagination" class="p-4 border-t border-gray-100 bg-gray-50/50">
                <style>
                    #area-pagination nav svg { width: 1.25rem; height: 1.25rem; display: inline-block; }
                    #area-pagination nav p { margin-top: 0; margin-bottom: 0; }
                </style>
                {{ $peminjamans->links() }}
            </div>
        </div>

        <footer class="bg-white border-t border-gray-200 text-gray-500 py-4 px-6 rounded-xl flex flex-col sm:flex-row justify-between items-center gap-2 text-xs mt-auto shadow-sm">
        <div class="text-center sm:text-left">
            <p class="font-medium text-gray-600 mb-0.5">Sistem Perpustakaan Sekolah</p>
            <p>&copy; 2026 - Sistem Dibangun oleh Aldi Aditya</p>
        </div>
        </footer>

    </div>

    <!-- LIBRARY SWEETALERT2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SCRIPT LOGIKA VERIFIKASI -->
    <script>
        function konfirmasiPengembalian(button) {
            Swal.fire({
                title: 'Verifikasi Pengembalian?',
                text: "Pastikan Anda sudah menerima buku fisik dari siswa yang bersangkutan.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Verifikasi!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-lg border border-gray-100',
                    confirmButton: 'px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm',
                    cancelButton: 'px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }
    </script>
    <!-- Script Live Search Peminjaman -->
    <script src="{{ asset('js/search-peminjaman.js') }}"></script>
</x-admin-layout>
