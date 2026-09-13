<x-admin-layout>
    <x-slot:title>
        Data Peminjaman - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Data Peminjaman</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola transaksi peminjaman dan pengembalian buku</p>

                <div class="mt-2 inline-block bg-purple-100 text-purple-700 px-3 py-1.5 rounded-lg text-xs font-bold border border-purple-200">
                    <i class="ph ph-books mr-1"></i> Total Sedang Dipinjam: {{ \App\Models\Peminjaman::where('status', 'Dipinjam')->count() }} Buku
                </div>
            </div>

            <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                <i class="ph ph-plus text-lg"></i>
                Proses Peminjaman
            </a>
        </div>

        <!-- TOMBOL FILTER (TABS) -->
        @php
            $currentFilter = request('filter', 'semua');
            $searchQuery = request('search');
        @endphp
        <div class="flex flex-nowrap overflow-x-auto gap-3 mb-4 pb-2 scrollbar-hide">
            <a href="{{ route('peminjaman.index', ['filter' => 'semua', 'search' => $searchQuery]) }}" class="whitespace-nowrap px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors {{ $currentFilter == 'semua' ? 'bg-gray-800 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                <i class="ph ph-list-dashes mr-1"></i> Semua Transaksi
            </a>
            <a href="{{ route('peminjaman.index', ['filter' => 'dipinjam', 'search' => $searchQuery]) }}" class="whitespace-nowrap px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors {{ $currentFilter == 'dipinjam' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                <i class="ph ph-clock mr-1"></i> Sedang Diproses
            </a>
            <a href="{{ route('peminjaman.index', ['filter' => 'terlambat', 'search' => $searchQuery]) }}" class="whitespace-nowrap px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors {{ $currentFilter == 'terlambat' ? 'bg-red-600 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                <i class="ph ph-warning-circle mr-1"></i> Telat Dikembalikan
            </a>
            <a href="{{ route('peminjaman.index', ['filter' => 'dikembalikan', 'search' => $searchQuery]) }}" class="whitespace-nowrap px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors {{ $currentFilter == 'dikembalikan' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                <i class="ph ph-check-circle mr-1"></i> Sudah Kembali
            </a>
        </div>

        <!-- Kolom Pencarian -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
            <form id="searchFormPeminjaman" data-url="{{ route('peminjaman.index') }}" action="{{ route('peminjaman.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full">
                <input type="hidden" name="filter" id="filterPeminjaman" value="{{ $currentFilter }}">

                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="ph ph-magnifying-glass text-gray-400 text-lg"></i>
                    </div>
                    <input type="text" id="searchInputPeminjaman" name="search" value="{{ request('search') }}" autocomplete="off" placeholder="Cari nama siswa, NIS, judul buku, atau status..."
                        class="pl-11 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-700 placeholder-gray-400">
                </div>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-sm focus:outline-none shrink-0 flex items-center gap-2">
                    <span id="searchLabelPeminjaman">Cari Data</span>
                    <i id="loadingSpinnerPeminjaman" class="ph ph-spinner-gap animate-spin hidden text-lg"></i>
                </button>
            </form>
        </div>

        <!-- Target JS Table Container Peminjaman -->
        <div id="table-container-peminjaman" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8 transition-opacity duration-300">

            @if(session('success'))
                <div class="bg-emerald-50 border-b border-emerald-100 p-4 flex items-center gap-3 text-emerald-700 text-sm font-medium">
                    <i class="ph ph-check-circle text-xl"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border-b border-red-100 p-4 flex items-center gap-3 text-red-700 text-sm font-medium">
                    <i class="ph ph-warning-circle text-xl"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead class="bg-purple-50 sticky top-0 z-10 outline outline-1 outline-purple-200">
                        <tr class="text-purple-700 text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-4 px-6 w-16 text-center">No</th>
                            <th class="py-4 px-6">Peminjam (Siswa)</th>
                            <th class="py-4 px-6">Buku</th>
                            <th class="py-4 px-6">Tgl Pinjam</th>
                            <th class="py-4 px-6">Jatuh Tempo</th>
                            <th class="py-4 px-6 text-center">Status</th>
                            <th class="py-4 px-6 text-center">Aksi (Verifikasi)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($peminjamans as $pinjam)
                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors text-sm">
                            <td class="py-4 px-6 text-gray-600 font-medium text-center">{{ $peminjamans->firstItem() + $loop->index }}</td>

                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold uppercase shrink-0">
                                        {{ substr($pinjam->anggota->nama_lengkap ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-gray-800 block">{{ $pinjam->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</span>
                                        <span class="text-xs text-gray-500 font-semibold bg-gray-100 px-2 py-0.5 rounded">Kelas {{ $pinjam->anggota->kelas ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    <i class="ph ph-book-open text-gray-400 text-lg shrink-0"></i>
                                    <span class="font-semibold text-gray-700 line-clamp-2">
                                        {{ $pinjam->buku->judul ?? 'Buku Dihapus' }}
                                    </span>
                                </div>
                            </td>

                            <td class="py-4 px-6 text-gray-600 text-xs">
                                {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->translatedFormat('d M Y') }}
                            </td>

                            <td class="py-4 px-6 text-gray-600 text-xs font-semibold">
                                @if($pinjam->status_aktual == 'Terlambat')
                                    <span class="text-red-600 flex items-center gap-1"><i class="ph ph-warning-circle"></i> {{ \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->translatedFormat('d M Y') }}</span>
                                @else
                                    {{ \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->translatedFormat('d M Y') }}
                                @endif
                            </td>

                            <td class="py-4 px-6 text-center">
                                @if($pinjam->status == 'Dikembalikan')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold rounded-lg uppercase tracking-wider whitespace-nowrap">
                                        <i class="ph ph-check-circle text-sm"></i> Dikembalikan
                                    </span>
                                @elseif($pinjam->status_aktual == 'Terlambat')
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-700 border border-red-200 text-[10px] font-bold rounded-lg uppercase tracking-wider whitespace-nowrap">
                                            <i class="ph ph-warning-circle text-sm"></i> Terlambat
                                        </span>
                                        <span class="text-[10px] text-red-500 font-bold mt-1">Lwt {{ $pinjam->hari_terlambat }} Hari</span>
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-200 text-[10px] font-bold rounded-lg uppercase tracking-wider whitespace-nowrap">
                                        <i class="ph ph-clock text-sm"></i> Dipinjam
                                    </span>
                                @endif
                            </td>

                            <!-- KOLOM AKSI / TOMBOL VERIFIKASI PENGEMBALIAN -->
                            <td class="py-4 px-6 text-center">
                                @if($pinjam->status == 'Dikembalikan')
                                    <span class="inline-flex items-center gap-1 text-emerald-600 font-bold text-xs bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100 whitespace-nowrap">
                                        <i class="ph ph-check-circle text-base"></i> Sudah Kembali
                                    </span>
                                @else
                                    <!-- TOMBOL MERAH VERIFIKASI PENGEMBALIAN -->
                                    <form action="{{ route('pengembalian.store', $pinjam->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin buku ini sudah dikembalikan? Stok buku akan otomatis bertambah.');">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors whitespace-nowrap group shadow-sm">
                                            <i class="ph ph-arrow-u-down-left text-base group-hover:-rotate-45 transition-transform"></i>
                                            Belum Kembali
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center -mt-4">
                                    <div class="w-24 h-24 rounded-full bg-purple-50 border-8 border-white shadow-sm flex items-center justify-center mb-4">
                                        <i class="ph ph-handshake text-4xl text-purple-500 block leading-none"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-1">Data Peminjaman Kosong</h3>
                                    <p class="text-sm font-medium text-gray-500 mb-6">Pencarian tidak cocok atau belum ada transaksi.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="p-4 border-t border-gray-100">
                {{ $peminjamans->links() }}
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
    <script src="{{ asset('js/sching-peminjaman.js') }}"></script>
</x-admin-layout>
