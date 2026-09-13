<x-admin-layout>
    <x-slot:title>
        Riwayat Pengembalian - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1">

        <!-- Header Halaman -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Riwayat Pengembalian</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar buku yang telah selesai dikembalikan oleh siswa</p>

                <div class="mt-2 inline-block bg-emerald-100 text-emerald-700 px-3 py-1.5 rounded-lg text-xs font-bold border border-emerald-200">
                    <i class="ph ph-check-square-offset mr-1"></i> Total Buku Kembali: {{ \App\Models\Peminjaman::where('status', 'Dikembalikan')->count() }} Buku
                </div>
            </div>
            <!-- Tombol "Proses Peminjaman" sudah dihapus dari sini agar UI lebih bersih -->
        </div>

        <!-- Kolom Pencarian -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
            <form id="searchFormPengembalian" data-url="{{ route('pengembalian.index') }}" action="{{ route('pengembalian.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="ph ph-magnifying-glass text-gray-400 text-lg"></i>
                    </div>
                    <input type="text" id="searchInputPengembalian" name="search" value="{{ request('search') }}" autocomplete="off" placeholder="Cari nama siswa, NIS, atau judul buku..."
                        class="pl-11 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition text-sm text-gray-700 placeholder-gray-400">
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-sm focus:outline-none shrink-0 flex items-center gap-2">
                    <span id="searchLabelPengembalian">Cari Riwayat</span>
                    <i id="loadingSpinnerPengembalian" class="ph ph-spinner-gap animate-spin hidden text-lg"></i>
                </button>
            </form>
        </div>

        <!-- Wadah Tabel Ajax -->
        <div id="table-container-pengembalian" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8 transition-opacity duration-300">

            @if(session('success'))
                <div class="bg-emerald-50 border-b border-emerald-100 p-4 flex items-center gap-3 text-emerald-700 text-sm font-medium">
                    <i class="ph ph-check-circle text-xl"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-auto w-full">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead class="bg-blue-50 sticky top-0 z-10 outline outline-1 outline-blue-200">
                        <tr class="text-blue-700 text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-4 px-6 w-16 text-center">No</th>
                            <th class="py-4 px-6">Siswa Peminjam</th>
                            <th class="py-4 px-6">Buku yang Dipinjam</th>
                            <th class="py-4 px-6">Tgl Pinjam</th>
                            <th class="py-4 px-6">Tgl Dikembalikan</th>
                            <th class="py-4 px-6 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">

                        @forelse($pengembalians as $kembali)
                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors text-sm">
                            <td class="py-4 px-6 text-gray-600 font-medium text-center">{{ $pengembalians->firstItem() + $loop->index }}</td>

                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold uppercase shrink-0">
                                        {{ substr($kembali->anggota->nama_lengkap ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-gray-800 block">{{ $kembali->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</span>
                                        <span class="text-xs text-gray-500 font-semibold bg-gray-100 px-2 py-0.5 rounded">Kelas {{ $kembali->anggota->kelas ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    <i class="ph ph-book-open text-gray-400 text-lg shrink-0"></i>
                                    <span class="font-semibold text-gray-700 line-clamp-2">
                                        {{ $kembali->buku->judul ?? 'Buku Dihapus' }}
                                    </span>
                                </div>
                            </td>

                            <td class="py-4 px-6 text-gray-600 text-xs">
                                {{ \Carbon\Carbon::parse($kembali->tanggal_pinjam)->translatedFormat('d M Y') }}
                            </td>

                            <td class="py-4 px-6 text-blue-600 text-xs font-semibold">
                                <div class="flex items-center gap-1.5">
                                    <i class="ph ph-check-circle"></i>
                                    {{ \Carbon\Carbon::parse($kembali->updated_at)->translatedFormat('d M Y') }}
                                </div>
                            </td>

                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-bold rounded-lg uppercase tracking-wider mx-auto">
                                    <i class="ph ph-check-square text-base"></i> Selesai
                                </span>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center -mt-4">
                                    <div class="w-24 h-24 rounded-full bg-gray-50 border-8 border-white shadow-sm flex items-center justify-center mb-4 text-gray-400">
                                        <i class="ph ph-clock-counter-clockwise text-4xl block leading-none"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-1">Riwayat Kosong</h3>
                                    <p class="text-sm font-medium text-gray-500 mb-6">Belum ada buku yang dikembalikan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="p-4 border-t border-gray-100">
                {{ $pengembalians->links() }}
            </div>
        </div>

        <footer class="bg-white border-t border-gray-200 text-gray-500 py-4 px-6 rounded-xl flex flex-col sm:flex-row justify-between items-center gap-2 text-xs mt-auto shadow-sm">
            <div class="text-center sm:text-left">
                <p class="font-medium text-gray-600 mb-0.5">Sistem Perpustakaan Sekolah</p>
                <p>&copy; {{ date('Y') }} - Sistem Dibangun oleh Agung Prastiyo</p>
            </div>
        </footer>
    </div>

    <!-- Panggil Javascript untuk Live Search -->
    <script src="{{ asset('js/sching-pengembalian.js') }}"></script>
</x-admin-layout>
