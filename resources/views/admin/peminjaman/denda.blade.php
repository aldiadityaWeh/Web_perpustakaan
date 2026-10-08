<x-admin-layout>
    <x-slot:title>
        Manajemen Denda - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 min-h-[85vh] w-full">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tagihan Denda Siswa</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola data pembayaran denda keterlambatan atau kerusakan buku.</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 px-5 py-2.5 rounded-xl font-medium transition-colors shadow-sm focus:outline-none">
                    <i class="ph ph-arrow-left text-lg"></i>
                    Kembali ke Peminjaman
                </a>
            </div>
        </div>

        <!-- PENCARIAN DENDA (Desain Kartu) -->
        <div class="mb-6 w-full bg-white p-3.5 rounded-xl border border-gray-100 shadow-sm">
            <form action="{{ route('denda.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full">
                <!-- Kotak Input -->
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="ph ph-magnifying-glass text-gray-400 text-lg"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" autocomplete="off" placeholder="Ketik Nama Siswa, NIS, atau Judul Buku..."
                    class="pl-10 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-red-600 outline-none transition text-sm text-gray-700 bg-white">
                </div>

                <!-- Tombol Cari -->
                <button type="submit" class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-8 py-2.5 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center whitespace-nowrap shrink-0">
                    Cari Tagihan
                </button>
            </form>
        </div>

        <!-- Tabel Denda -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">

            @if(session('success'))
                <div class="bg-emerald-50 border-b border-emerald-100 p-4 flex items-center gap-3 text-emerald-700 text-sm font-medium">
                    <i class="ph ph-check-circle text-xl"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead class="bg-red-50/50 sticky top-0 z-10 border-b border-red-100">
                        <tr class="text-red-800 text-xs font-bold uppercase tracking-wider">
                            <th class="py-4 px-6 w-16 text-center">No</th>
                            <th class="py-4 px-6">Nama Siswa</th>
                            <th class="py-4 px-6">Buku & Kondisi</th>
                            <th class="py-4 px-6 text-right">Nominal Denda</th>
                            <th class="py-4 px-6 text-center">Status Bayar</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($peminjamans as $pinjam)
                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors text-sm">
                            <td class="py-4 px-6 text-gray-500 font-medium text-center">{{ $peminjamans->firstItem() + $loop->index }}</td>

                            <td class="py-4 px-6">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-800">{{ $pinjam->anggota->nama_lengkap }}</span>
                                    <span class="text-xs text-gray-500 font-mono mt-0.5">NIS: {{ $pinjam->anggota->nis }}</span>
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <div class="flex flex-col">
                                    <span class="font-medium text-gray-700 block line-clamp-1" title="{{ $pinjam->buku->judul }}">{{ $pinjam->buku->judul }}</span>
                                    <span class="text-[11px] text-gray-400 mt-1 line-clamp-1">{{ $pinjam->catatan ?? 'Tidak ada catatan khusus' }}</span>
                                </div>
                            </td>

                            <td class="py-4 px-6 text-right">
                                <span class="font-black text-red-600 text-base block">
                                    Rp {{ number_format($pinjam->denda, 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="py-4 px-6 text-center">
                                @if($pinjam->status_denda == 'Lunas')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold rounded-full uppercase tracking-wider">
                                        <i class="ph ph-check-circle-fill text-sm"></i> LUNAS
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 border border-red-200 text-xs font-bold rounded-full uppercase tracking-wider animate-pulse">
                                        <i class="ph ph-warning-circle-fill text-sm"></i> BELUM LUNAS
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Tombol Detail (Mata Biru) -->
                                    <a href="{{ route('peminjaman.show', $pinjam->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail Transaksi">
                                        <i class="ph ph-eye text-xl font-bold"></i>
                                    </a>

                                    @if($pinjam->status_denda != 'Lunas')
                                        <!-- Tombol Tandai Lunas -->
                                        <div x-data="{ showLunasModal: false }" class="inline-block">
                                            <button @click="showLunasModal = true" type="button" class="bg-gray-900 hover:bg-black text-white px-4 py-2 rounded-lg text-xs font-bold transition-all shadow-sm flex items-center gap-1.5">
                                                <i class="ph ph-hand-coins text-base"></i> Terima Uang
                                            </button>

                                            <!-- Modal Konfirmasi Lunas -->
                                            <div x-show="showLunasModal" x-cloak class="fixed inset-0 z-[99] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 text-left">
                                                <div @click.away="showLunasModal = false" class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl transform transition-all">
                                                    <div class="flex items-center gap-4 mb-5">
                                                        <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl shrink-0">
                                                            <i class="ph ph-money"></i>
                                                        </div>
                                                        <div>
                                                            <h3 class="font-bold text-gray-900 text-base">Konfirmasi Pembayaran</h3>
                                                            <p class="text-xs text-gray-500 mt-1">Pastikan Anda sudah menerima uangnya.</p>
                                                        </div>
                                                    </div>
                                                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 mb-6 text-center">
                                                        <p class="text-xs text-gray-500 mb-1 uppercase font-bold tracking-widest">Total Terima</p>
                                                        <p class="text-2xl font-black text-gray-900">Rp {{ number_format($pinjam->denda, 0, ',', '.') }}</p>
                                                    </div>
                                                    <div class="flex justify-end gap-3">
                                                        <button @click="showLunasModal = false" type="button" class="px-4 py-2.5 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 flex-1">Batal</button>

                                                        <form action="{{ route('denda.lunas', $pinjam->id) }}" method="POST" class="flex-1">
                                                            @csrf
                                                            <button type="submit" class="w-full px-4 py-2.5 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-md">Sudah Lunas</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 rounded-full bg-gray-50 border-4 border-gray-100 flex items-center justify-center mb-3">
                                        <i class="ph ph-check-circle text-4xl text-emerald-400"></i>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-800">Tidak ada tagihan denda</h3>
                                    <p class="text-sm font-medium text-gray-500 mt-1">Semua siswa tertib atau denda sudah dicari tidak ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                <style>
                    /* Sedikit penyesuaian SVG agar pagination terlihat sejajar & rapi */
                    .p-4 nav svg { width: 1.25rem; height: 1.25rem; display: inline-block; }
                    .p-4 nav p { margin-top: 0; margin-bottom: 0; }
                </style>
                {{ $peminjamans->links() }}
            </div>
        </div>

    </div>
</x-admin-layout>
