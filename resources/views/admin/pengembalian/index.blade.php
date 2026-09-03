<x-admin-layout>
    @slot('title')
        Proses Pengembalian - Sistem Perpustakaan
    @endslot

    <div class="flex flex-col h-full min-h-full">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Proses Pengembalian</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar buku yang sedang dipinjam dan belum dikembalikan</p>
            </div>
        </div>

        <!-- Kolom Pencarian (Simpel tanpa opsi) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
            <form action="{{ route('pengembalian.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="ph ph-magnifying-glass text-gray-400 text-lg"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Siswa atau Judul Buku..."
                        class="pl-11 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-700 placeholder-gray-400">
                </div>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors shadow-sm focus:outline-none shrink-0">
                    Cari Data
                </button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">

            @if(session('success'))
                <div class="bg-emerald-50 border-b border-emerald-100 p-4 flex items-center gap-3 text-emerald-700 text-sm font-medium">
                    <i class="ph ph-check-circle text-xl"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border-b border-red-100 p-4 flex items-center gap-3 text-red-700 text-sm font-medium">
                    <i class="ph ph-warning-circle text-xl"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="bg-purple-50/50 border-b border-gray-100 text-gray-500 text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-4 px-6 w-16 text-center">NO</th>
                            <th class="py-4 px-6">PEMINJAM</th>
                            <th class="py-4 px-6">BUKU YANG DIPINJAM</th>
                            <th class="py-4 px-6">TGL PINJAM</th>
                            <th class="py-4 px-6">BATAS KEMBALI</th>
                            <th class="py-4 px-6">STATUS WAKTU</th>
                            <th class="py-4 px-6 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $pinjam)

                        @php
                            // Hitung status keterlambatan secara realtime untuk UI
                            $jatuhTempo = \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->startOfDay();
                            $hariIni = \Carbon\Carbon::now()->startOfDay();
                            $isTerlambat = $hariIni->greaterThan($jatuhTempo);
                            // Cek jika jatuh tempo hari ini
                            $selisih = $hariIni->diffInDays($jatuhTempo);
                        @endphp

                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors text-sm">
                            <td class="py-4 px-6 text-gray-600 font-medium text-center">{{ $peminjamans->firstItem() + $loop->index }}</td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-gray-800">{{ $pinjam->anggota->nama_lengkap ?? 'Anggota Dihapus' }}</p>
                                <p class="text-xs text-gray-500">Kelas {{ $pinjam->anggota->kelas ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-gray-800">{{ $pinjam->buku->judul ?? 'Buku Dihapus' }}</p>
                            </td>
                            <td class="py-4 px-6 text-gray-600">
                                {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-medium {{ $isTerlambat ? 'text-red-600' : 'text-gray-800' }}">
                                    {{ \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->format('d M Y') }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @if($isTerlambat)
                                    <span class="px-2.5 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">
                                        Telat {{ $selisih }} Hari
                                    </span>
                                @elseif($selisih == 0)
                                    <span class="px-2.5 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">
                                        Hari Ini
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">
                                        Sisa {{ $selisih }} Hari
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <!-- Modal Alpine untuk Proses Kembali -->
                                <div x-data="{ showModal: false }" class="inline-block">
                                    <button @click="showModal = true" type="button" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
                                        Terima Buku
                                    </button>

                                    <div x-show="showModal" x-cloak class="fixed inset-0 z-[99] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 text-left">
                                        <div @click.away="showModal = false" class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl transform transition-all text-left">
                                            <div class="flex items-center gap-4 mb-4">
                                                <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl shrink-0">
                                                    <i class="ph ph-hand-heart"></i>
                                                </div>
                                                <div>
                                                    <h3 class="font-bold text-gray-900 text-lg">Proses Pengembalian?</h3>
                                                    <p class="text-sm text-gray-500 mt-0.5">Stok buku akan otomatis ditambah 1.</p>
                                                </div>
                                            </div>

                                            @if($isTerlambat)
                                                <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm mb-4">
                                                    <i class="ph ph-warning-circle font-bold"></i> Perhatian: Peminjaman ini terlambat {{ $selisih }} hari. Sistem akan mencatat denda sebesar <b>Rp {{ number_format($selisih * 500, 0, ',', '.') }}</b>.
                                                </div>
                                            @endif

                                            <div class="flex justify-end gap-3 mt-6">
                                                <button @click="showModal = false" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50">Batal</button>
                                                <form action="{{ route('pengembalian.update', $pinjam->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-700">Ya, Kembalikan Buku</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <!-- Empty State yang Elegan -->
                        <tr>
                            <td colspan="7" class="py-20 text-center">
                                <div class="flex flex-col items-center justify-center -mt-4">
                                    <div class="w-24 h-24 rounded-full bg-green-50 border-8 border-white shadow-sm flex items-center justify-center mb-4">
                                        <i class="ph ph-check-circle text-4xl text-green-500 block leading-none"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-1">Semua Buku Telah Kembali</h3>
                                    <p class="text-sm font-medium text-gray-500">Tidak ada transaksi peminjaman yang sedang berlangsung saat ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-100">
                {{ $peminjamans->links() }}
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
