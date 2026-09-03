<x-admin-layout>
    @slot('title')
        Detail Transaksi - Sistem Perpustakaan
    @endslot

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Transaksi</h1>
            <p class="text-sm text-gray-500 mt-1">Informasi lengkap riwayat peminjaman buku</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('transaksi.index') }}" class="inline-flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                <i class="ph ph-arrow-left text-lg"></i>
                Kembali
            </a>
            <!-- Tombol Cetak Struk (Tampilan visual) -->
            <button type="button" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                <i class="ph ph-printer text-lg"></i>
                Cetak Bukti
            </button>
        </div>
    </div>

    <!-- Container Struk / Detail -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl mx-auto mb-8">

        <!-- Header Struk -->
        <div class="bg-purple-50/50 p-6 sm:p-8 border-b border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="h-16 w-16 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-3xl shadow-sm shrink-0">
                    <i class="ph ph-receipt"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">ID TRANSAKSI</p>
                    <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">#TRX-{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</h2>
                </div>
            </div>

            <!-- Status Badge Raksasa -->
            <div class="text-center sm:text-right">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">STATUS SAAT INI</p>
                @if($transaksi->status == 'dikembalikan')
                    <span class="inline-block px-4 py-2 bg-green-100 text-green-700 text-sm font-black rounded-lg uppercase tracking-wider border border-green-200">SELESAI</span>
                @elseif($transaksi->status == 'dipinjam')
                    <span class="inline-block px-4 py-2 bg-amber-100 text-amber-700 text-sm font-black rounded-lg uppercase tracking-wider border border-amber-200">DIPINJAM</span>
                @elseif($transaksi->status == 'terlambat')
                    <span class="inline-block px-4 py-2 bg-red-100 text-red-700 text-sm font-black rounded-lg uppercase tracking-wider border border-red-200">TERLAMBAT KEMBALI</span>
                @else
                    <span class="inline-block px-4 py-2 bg-gray-100 text-gray-700 text-sm font-black rounded-lg uppercase tracking-wider border border-gray-200">{{ $transaksi->status }}</span>
                @endif
            </div>
        </div>

        <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Kolom Kiri: Info Peminjam & Buku -->
            <div class="flex flex-col gap-6">
                <!-- Info Peminjam -->
                <div>
                    <h3 class="text-sm font-bold text-gray-800 border-b border-gray-100 pb-2 mb-3 flex items-center gap-2">
                        <i class="ph ph-user text-purple-600"></i> Informasi Peminjam
                    </h3>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <p class="font-bold text-gray-800 text-lg mb-1">{{ $transaksi->anggota->nama_lengkap ?? 'Anggota telah dihapus' }}</p>
                        <p class="text-sm text-gray-600 flex items-center gap-2">
                            <i class="ph ph-identification-card"></i> NIS: {{ $transaksi->anggota->nis ?? '-' }}
                        </p>
                        <p class="text-sm text-gray-600 flex items-center gap-2 mt-1">
                            <i class="ph ph-chalkboard-teacher"></i> Kelas: {{ $transaksi->anggota->kelas ?? '-' }}
                        </p>
                    </div>
                </div>

                <!-- Info Buku -->
                <div>
                    <h3 class="text-sm font-bold text-gray-800 border-b border-gray-100 pb-2 mb-3 flex items-center gap-2">
                        <i class="ph ph-book-open text-purple-600"></i> Buku yang Dipinjam
                    </h3>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex gap-4">
                        @if(isset($transaksi->buku->gambar_sampul))
                            <img src="{{ asset('storage/' . $transaksi->buku->gambar_sampul) }}" alt="Sampul" class="w-16 h-24 object-cover rounded shadow-sm border border-gray-200 shrink-0">
                        @else
                            <div class="w-16 h-24 bg-white rounded flex items-center justify-center text-gray-300 border border-gray-200 shrink-0 shadow-sm">
                                <i class="ph ph-image text-2xl"></i>
                            </div>
                        @endif
                        <div>
                            <p class="font-bold text-gray-800 leading-snug">{{ $transaksi->buku->judul ?? 'Buku telah dihapus' }}</p>
                            <p class="text-xs font-semibold text-purple-600 mt-1 uppercase">{{ $transaksi->buku->kategori ?? '-' }}</p>
                            <p class="text-xs text-gray-500 mt-2">ISBN: {{ $transaksi->buku->isbn ?? '-' }}</p>
                            <p class="text-xs text-gray-500">Rak: {{ $transaksi->buku->rak ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Rincian Waktu & Denda -->
            <div class="flex flex-col gap-6">
                <!-- Rincian Waktu -->
                <div>
                    <h3 class="text-sm font-bold text-gray-800 border-b border-gray-100 pb-2 mb-3 flex items-center gap-2">
                        <i class="ph ph-clock text-purple-600"></i> Garis Waktu
                    </h3>
                    <div class="flex flex-col gap-4">
                        <!-- Tgl Pinjam -->
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Tanggal Pinjam</span>
                            <span class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->translatedFormat('d F Y') }}</span>
                        </div>
                        <!-- Tgl Jatuh Tempo -->
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Batas Pengembalian</span>
                            <span class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($transaksi->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}</span>
                        </div>
                        <!-- Tgl Kembali Sebenarnya -->
                        <div class="flex justify-between items-center p-3 bg-blue-50/50 rounded-lg border border-blue-100">
                            <span class="text-sm text-gray-600 font-medium">Dikembalikan Pada</span>
                            @if($transaksi->tanggal_kembali)
                                <span class="text-sm font-black text-blue-700">{{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->translatedFormat('d F Y') }}</span>
                            @else
                                <span class="text-sm font-bold text-gray-400 italic">Belum Dikembalikan</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Info Denda & Catatan -->
                <div>
                    <h3 class="text-sm font-bold text-gray-800 border-b border-gray-100 pb-2 mb-3 flex items-center gap-2">
                        <i class="ph ph-wallet text-purple-600"></i> Informasi Tambahan
                    </h3>

                    @if($transaksi->denda > 0)
                    <div class="bg-red-50 p-4 rounded-xl border border-red-100 mb-4 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-red-500 uppercase tracking-wider mb-0.5">Total Denda Keterlambatan</p>
                            <p class="text-xs text-red-400">Harus dibayarkan oleh siswa</p>
                        </div>
                        <p class="text-2xl font-black text-red-600">Rp {{ number_format($transaksi->denda, 0, ',', '.') }}</p>
                    </div>
                    @else
                    <div class="bg-emerald-50 p-4 rounded-xl border border-emerald-100 mb-4 flex items-center gap-3">
                        <i class="ph ph-check-circle text-2xl text-emerald-500"></i>
                        <div>
                            <p class="text-sm font-bold text-emerald-700">Tidak Ada Denda</p>
                            <p class="text-xs text-emerald-600">Transaksi aman tanpa denda keterlambatan.</p>
                        </div>
                    </div>
                    @endif

                    <!-- Catatan Peminjaman -->
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Catatan Peminjaman</p>
                        <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100 italic">
                            {{ $transaksi->catatan ?: 'Tidak ada catatan khusus saat peminjaman.' }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-admin-layout>
