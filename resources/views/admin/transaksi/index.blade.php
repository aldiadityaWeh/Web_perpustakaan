<x-admin-layout>
    @slot('title')
        Riwayat Transaksi - Sistem Perpustakaan
    @endslot

    <div class="flex flex-col h-full min-h-full">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Riwayat Transaksi</h1>
                <p class="text-sm text-gray-500 mt-1">Log keseluruhan aktivitas peminjaman dan pengembalian buku</p>
            </div>

            <!-- Tombol Cetak / Ekspor Laporan -->
            <button type="button" class="inline-flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-5 py-2.5 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                <i class="ph ph-printer text-lg"></i>
                Cetak Laporan
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
            <form action="{{ route('transaksi.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="ph ph-magnifying-glass text-gray-400 text-lg"></i>
                    </div>
                    <!-- Ditambahkan autocomplete off -->
                    <input type="text" name="search" value="{{ request('search') }}" autocomplete="off" placeholder="Cari Nama Siswa atau Judul Buku..."
                        class="pl-11 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-700 placeholder-gray-400">

                    @if(request('search'))
                        <a href="{{ route('transaksi.index') }}" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-red-500 transition-colors" title="Bersihkan Pencarian">
                            <i class="ph ph-x-circle text-lg"></i>
                        </a>
                    @endif
                </div>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-sm focus:outline-none shrink-0">
                    Cari Data
                </button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="bg-emerald-50 border-b border-emerald-100 p-4 flex items-center gap-3 text-emerald-700 text-sm font-medium">
                    <i class="ph ph-check-circle text-xl"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="bg-purple-50/50 border-b border-gray-100 text-gray-500 text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-4 px-6 w-16 text-center">NO</th>
                            <th class="py-4 px-6">PEMINJAM (KELAS)</th>
                            <th class="py-4 px-6">JUDUL BUKU</th>
                            <th class="py-4 px-6">TGL PINJAM</th>
                            <th class="py-4 px-6">TGL KEMBALI</th>
                            <th class="py-4 px-6">STATUS</th>
                            <th class="py-4 px-6 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $trx)
                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors text-sm">
                            <td class="py-4 px-6 text-gray-600 font-medium text-center">
                                {{ $transaksis->firstItem() + $loop->index }}
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-gray-800">{{ $trx->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</p>
                                <p class="text-xs text-gray-500">Kelas {{ $trx->anggota->kelas ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-gray-800">{{ $trx->buku->judul ?? 'Buku Dihapus' }}</p>
                            </td>
                            <td class="py-4 px-6 text-gray-600">
                                {{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6 text-gray-600">
                                @if($trx->tanggal_kembali)
                                    {{ \Carbon\Carbon::parse($trx->tanggal_kembali)->format('d M Y') }}
                                @else
                                    <span class="text-gray-400 italic">Belum kembali</span>
                                @endif
                            </td>

                            <td class="py-4 px-6">
                                @if($trx->status == 'dikembalikan')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-lg uppercase tracking-wider inline-block">Selesai</span>
                                @elseif($trx->status == 'dipinjam')
                                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-lg uppercase tracking-wider inline-block">Dipinjam</span>
                                @elseif($trx->status == 'terlambat')
                                    <div class="flex flex-col items-start gap-1">
                                        <span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded-lg uppercase tracking-wider inline-block">Terlambat</span>
                                        <!-- Menampilkan Nominal Denda -->
                                        @if($trx->denda > 0)
                                            <span class="text-[11px] font-bold text-red-600 whitespace-nowrap">Denda: Rp {{ number_format($trx->denda, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 text-[10px] font-bold rounded-lg uppercase tracking-wider inline-block">{{ $trx->status }}</span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-center">
                                <div x-data="{ showDeleteModal: false }" class="inline-flex items-center justify-center gap-2">

                                    <!-- Tombol Detail / Show -->
                                    <a href="{{ route('transaksi.show', $trx->id) }}" class="p-2 text-teal-600 hover:bg-teal-50 rounded-lg transition-colors" title="Lihat Detail Transaksi">
                                        <i class="ph ph-eye text-lg"></i>
                                    </a>

                                    <button @click="showDeleteModal = true" type="button" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Riwayat">
                                        <i class="ph ph-trash text-lg"></i>
                                    </button>

                                    <!-- Modal Konfirmasi Hapus -->
                                    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[99] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 text-left">
                                        <div @click.away="showDeleteModal = false" class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl transform transition-all text-left">
                                            <div class="flex items-center gap-4 mb-4">
                                                <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xl shrink-0">
                                                    <i class="ph ph-warning-circle block leading-none"></i>
                                                </div>
                                                <div>
                                                    <h3 class="font-bold text-gray-900 text-base">Hapus Riwayat?</h3>
                                                    <p class="text-xs text-gray-500 mt-1">Catatan transaksi ini akan dihapus permanen dari sistem.</p>
                                                </div>
                                            </div>
                                            <div class="flex justify-end gap-3 mt-6">
                                                <button @click="showDeleteModal = false" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50">Batal</button>
                                                <form action="{{ route('transaksi.destroy', $trx->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700">Ya, Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <!-- Empty State View -->
                        <tr>
                            <td colspan="7" class="py-24 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="ph ph-receipt text-6xl mb-4 text-gray-300 block leading-none"></i>
                                    <p class="text-sm font-medium text-gray-500">Belum ada riwayat transaksi</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-gray-100">
                {{ $transaksis->links() }}
            </div>
        </div>


        <!-- Bagian Footer yang dikembalikan -->
        <footer class="bg-white border-t border-gray-200 text-gray-500 py-4 px-6 rounded-xl flex flex-col sm:flex-row justify-between items-center gap-2 text-xs mt-auto shadow-sm">
            <div class="text-center sm:text-left">
                <p class="font-medium text-gray-600 mb-0.5">Sistem Perpustakaan Sekolah</p>
                <p>&copy; 2026 - Sistem Dibangun oleh Agung Prastiyo</p>
            </div>
            <div class="flex gap-4 text-lg text-gray-400">
                <a href="#" class="hover:text-purple-600 transition-colors" title="Github">
                    <i class="ph ph-github-logo"></i>
                </a>
                <a href="#" class="hover:text-purple-600 transition-colors" title="Bantuan">
                    <i class="ph ph-question"></i>
                </a>
            </div>
        </footer>

    </div>
</x-admin-layout>
