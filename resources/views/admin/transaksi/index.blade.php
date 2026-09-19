<x-admin-layout>
    <x-slot:title>
        Kas Denda - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 min-h-[85vh] w-full">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Kas Denda Perpustakaan</h1>
                <p class="text-sm text-gray-500 mt-1">Laporan pemasukan dari denda keterlambatan dan kerusakan buku</p>
            </div>
        </div>

        <!-- KARTU TOTAL KAS -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl p-6 shadow-md mb-6 text-white flex items-center gap-5 relative overflow-hidden">
            <i class="ph ph-wallet absolute -right-4 -bottom-6 text-[120px] text-white opacity-10"></i>
            <div class="bg-white/20 p-4 rounded-xl backdrop-blur-sm shrink-0">
                <i class="ph ph-money text-4xl text-white"></i>
            </div>
            <div>
                <p class="text-purple-100 text-sm font-medium mb-1">Total Pemasukan Kas Denda</p>
                <h2 class="text-3xl font-bold tracking-tight">Rp {{ number_format($totalKas, 0, ',', '.') }}</h2>
            </div>
        </div>

        <!-- PENCARIAN -->
        <div class="mb-6 w-full bg-white p-3.5 rounded-xl border border-gray-100 shadow-sm">
            <!-- Tambahkan id="searchForm" -->
            <form id="searchForm" action="{{ route('transaksi.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="ph ph-magnifying-glass text-gray-400 text-lg"></i>
                    </div>
                    <!-- Tambahkan id="searchInput" -->
                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}" autocomplete="off" placeholder="Ketik Nama Siswa atau NIS pembayar denda..."
                        class="pl-10 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-700 bg-white">
                </div>

                <button type="submit" class="w-full sm:w-auto bg-purple-600 hover:bg-purple-700 text-white px-8 py-2.5 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center whitespace-nowrap shrink-0">
                    Cari Transaksi
                </button>
            </form>
        </div>

        <!-- WADAH TABEL -->
        <!-- Tambahkan id="table-container" di sini -->
        <div id="table-container" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead class="bg-purple-50/50 border-b border-gray-200">
                        <tr class="text-gray-500 text-xs font-bold uppercase tracking-wider">
                            <th class="py-4 px-6">Tanggal Pembayaran</th>
                            <th class="py-4 px-6">Nama Siswa</th>
                            <th class="py-4 px-6">Keterangan / Judul Buku</th>
                            <th class="py-4 px-6 text-right">Nominal Masuk</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($transaksis as $trx)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors text-sm">

                            <!-- Kolom Tanggal -->
                            <td class="py-4 px-6 text-gray-600">
                                <span class="font-semibold block">{{ \Carbon\Carbon::parse($trx->updated_at)->format('d M Y') }}</span>
                                <span class="text-[10px] text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($trx->updated_at)->format('H:i') }} WIB</span>
                            </td>

                            <!-- Kolom Siswa -->
                            <td class="py-4 px-6">
                                <span class="font-bold text-gray-800 block">{{ $trx->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</span>
                                <span class="text-xs text-gray-500 mt-1 block">NIS: {{ $trx->anggota->nis ?? '-' }}</span>
                            </td>

                            <!-- Kolom Keterangan -->
                            <td class="py-4 px-6">
                                <div class="text-xs text-gray-600">
                                    <span class="font-medium text-gray-800">Buku:</span> {{ $trx->buku->judul ?? '-' }} <br>
                                    <span class="font-medium text-gray-800 mt-1 inline-block">Sebab:</span>
                                    <span class="text-red-500">{{ $trx->catatan ?? 'Terlambat' }}</span>
                                </div>
                            </td>

                            <!-- Kolom Nominal -->
                            <td class="py-4 px-6 text-right font-bold text-emerald-600">
                                + Rp {{ number_format($trx->denda, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-500 text-sm">
                                Belum ada transaksi kas denda masuk yang sesuai pencarian.
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
                {{ $transaksis->links() }}
            </div>
        </div>

        <footer class="bg-white border-t border-gray-200 text-gray-500 py-4 px-6 rounded-xl flex flex-col sm:flex-row justify-between items-center gap-2 text-xs mt-auto shadow-sm">
        <div class="text-center sm:text-left">
            <p class="font-medium text-gray-600 mb-0.5">Sistem Perpustakaan Sekolah</p>
            <p>&copy; 2026 - Sistem Dibangun oleh Aldi Aditya</p>
        </div>
        </footer>

    </div>

    <!-- Panggil File JS Eksternal yang tadi dibuat di folder Public -->
    <script src="{{ asset('js/search-transaksi.js') }}"></script>
</x-admin-layout>
