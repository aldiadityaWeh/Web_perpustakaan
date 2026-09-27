<x-admin-layout>
    <x-slot:title>
        Manajemen Denda - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1">
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
                    <thead class="bg-red-50 sticky top-0 z-10 outline outline-1 outline-red-100">
                        <tr class="text-red-800 text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-4 px-6 w-16 text-center">No</th>
                            <th class="py-4 px-6">Nama Siswa</th>
                            <th class="py-4 px-6">Buku & Kondisi</th>
                            <th class="py-4 px-6 text-right">Nominal Denda</th>
                            <th class="py-4 px-6 text-center">Status Bayar</th>
                            <th class="py-4 px-6 text-center">Aksi Validasi</th>
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
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold rounded-lg uppercase tracking-wider">
                                        <i class="ph ph-check-circle-fill text-sm"></i> LUNAS
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 border border-red-200 text-xs font-bold rounded-lg uppercase tracking-wider animate-pulse">
                                        <i class="ph ph-warning-circle-fill text-sm"></i> BELUM LUNAS
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-center">
                                @if($pinjam->status_denda != 'Lunas')
                                    <!-- Tombol Tandai Lunas -->
                                    <div x-data="{ showLunasModal: false }" class="inline-block">
                                        <button @click="showLunasModal = true" type="button" class="bg-gray-900 hover:bg-black text-white px-4 py-2 rounded-lg text-xs font-bold transition-all shadow-md flex items-center gap-2">
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
                                                        <button type="submit" class="w-full px-4 py-2.5 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-md">Ya, Sudah Lunas</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs font-medium italic">Selesai</span>
                                @endif
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
                                    <p class="text-sm font-medium text-gray-500 mt-1">Semua siswa tertib atau denda sudah lunas.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-gray-100">
                {{ $peminjamans->links() }}
            </div>
        </div>

    </div>
</x-admin-layout>
