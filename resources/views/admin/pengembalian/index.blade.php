<x-admin-layout>
    <x-slot:title>
        Riwayat Pengembalian - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 min-h-[85vh] w-full">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Riwayat Pengembalian</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar buku yang telah selesai dikembalikan</p>
            </div>
        </div>

        <!-- PENCARIAN -->
        <div class="mb-6 w-full bg-white p-3.5 rounded-xl border border-gray-100 shadow-sm">
            <form action="{{ route('pengembalian.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="ph ph-magnifying-glass text-gray-400 text-lg"></i>
                    </div>
                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}" autocomplete="off" placeholder="Ketik Nama Siswa, NIS, atau Kelas..."
                    class="pl-10 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-700 bg-white">
                </div>

                <button type="submit" class="w-full sm:w-auto bg-purple-600 hover:bg-purple-700 text-white px-8 py-2.5 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center whitespace-nowrap shrink-0">
                    Cari Data
                </button>
            </form>
        </div>

        <!-- WADAH TABEL -->
        <div id="table-container" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="overflow-x-auto w-full">
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead class="bg-purple-50/50 border-b border-gray-200">
                        <tr class="text-gray-500 text-xs font-bold uppercase tracking-wider">
                            <th class="py-4 px-6">Buku & Peminjam</th>
                            <th class="py-4 px-6 text-center">Tgl Dikembalikan</th>
                            <th class="py-4 px-6 text-center">Denda (Rp)</th>
                            <th class="py-4 px-6">Kondisi / Catatan</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($pengembalians as $kembali)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors text-sm">

                            <!-- Kolom Buku & Peminjam -->
                            <td class="py-4 px-6">
                                <span class="font-bold text-gray-800 block">{{ $kembali->buku->judul ?? 'Buku Dihapus' }}</span>
                                <span class="text-xs text-gray-500 mt-1 block">Peminjam: <span class="font-medium text-gray-700">{{ $kembali->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</span></span>
                            </td>

                            <!-- Kolom Tanggal Dikembalikan -->
                            <td class="py-4 px-6 text-center text-gray-600">
                                {{ \Carbon\Carbon::parse($kembali->updated_at)->format('d M Y') }}
                                <span class="block text-[10px] text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($kembali->updated_at)->format('H:i') }} WIB</span>
                            </td>

                            <!-- Kolom Denda -->
                            <td class="py-4 px-6 text-center">
                                @if($kembali->denda > 0)
                                    <span class="inline-block px-3 py-1 bg-red-50 text-red-600 text-xs font-bold rounded-md border border-red-100">
                                        Rp {{ number_format($kembali->denda, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs font-medium">Gratis / Rp 0</span>
                                @endif
                            </td>

                            <!-- Kolom Catatan -->
                            <td class="py-4 px-6">
                                <div class="max-w-[200px] truncate text-xs text-gray-600" title="{{ $kembali->catatan ?? 'Kondisi Aman' }}">
                                    @if(str_contains($kembali->catatan, 'Kondisi Buku: Rusak') || str_contains($kembali->catatan, 'Hilang'))
                                        <span class="text-red-500 font-semibold"><i class="ph ph-warning"></i> {{ $kembali->catatan }}</span>
                                    @else
                                        {{ $kembali->catatan ?? 'Kondisi Aman' }}
                                    @endif
                                </div>
                            </td>

                            <!-- Kolom Aksi (Hanya lihat detail) -->
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('peminjaman.show', $kembali->id) }}" class="text-blue-600 hover:text-blue-800 transition-colors flex items-center justify-center gap-1 text-xs font-semibold" title="Lihat Detail Transaksi">
                                    <i class="ph ph-eye text-lg"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-500 text-sm">
                                Belum ada riwayat pengembalian buku.
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
                {{ $pengembalians->links() }}
            </div>
        </div>

        <footer class="bg-white border-t border-gray-200 text-gray-500 py-4 px-6 rounded-xl flex flex-col sm:flex-row justify-between items-center gap-2 text-xs mt-auto shadow-sm">
        <div class="text-center sm:text-left">
            <p class="font-medium text-gray-600 mb-0.5">Sistem Perpustakaan Sekolah</p>
            <p>&copy; 2026 - Sistem Dibangun oleh Aldi Aditya</p>
        </div>
        </footer>

    </div>

    <!-- Script Live Search Pengembalian -->
    <script src="{{ asset('js/search-pengembalian.js') }}"></script>
</x-admin-layout>
