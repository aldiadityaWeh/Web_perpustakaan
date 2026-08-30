<x-admin-layout>
    <x-slot:title>
        Data Buku - Sistem Perpustakaan
    </x-slot:title>

    <!-- STREAMING_CHUNK: Mengubah tombol menjadi tag <a> menuju route create dan menghapus wrapper Alpine -->
    <div class="flex flex-col h-full min-h-full">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Buku</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola koleksi buku perpustakaan</p>
        </div>

        <!-- Mengubah tag <button> menjadi <a> untuk pindah halaman -->
        <a href="{{ route('buku.create') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
            <i class="ph ph-plus text-lg"></i>
            Tambah Buku
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6 flex flex-col md:flex-row gap-4">

        <!-- Search Input -->
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="ph ph-magnifying-glass text-gray-400 text-lg"></i>
            </div>
            <input type="text" placeholder="Cari buku..."
                class="pl-11 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-700 placeholder-gray-400">
        </div>

        <!-- Filters & Action -->
        <div class="flex items-center gap-3 shrink-0">
            <!-- Kategori Dropdown -->
            <div class="relative">
                <select class="appearance-none pl-4 pr-10 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm bg-white text-gray-700 cursor-pointer w-full md:w-48">
                    <option value="">Semua Kategori</option>
                    <option value="fiksi">Fiksi</option>
                    <option value="non-fiksi">Non-Fiksi</option>
                    <option value="pelajaran">Buku Pelajaran</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <i class="ph ph-caret-down text-gray-500"></i>
                </div>
            </div>

            <!-- Refresh Button -->
            <button type="button" class="p-2.5 border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-600 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-600" title="Muat Ulang">
                <i class="ph ph-arrows-clockwise text-lg"></i>
            </button>
        </div>
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
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-purple-50/50 border-b border-gray-100 text-gray-500 text-[11px] font-bold uppercase tracking-wider">
                        <th class="py-4 px-6 w-16 text-center">No</th>
                        <th class="py-4 px-6">Judul Buku</th>
                        <th class="py-4 px-6">Pengarang</th>
                        <th class="py-4 px-6">Stok</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Menggunakan forelse untuk melooping data dari variabel $bukus -->
                    @forelse($bukus as $buku)
                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors text-sm">
                        <td class="py-4 px-6 text-gray-600 font-medium text-center">{{ $bukus->firstItem() + $loop->index }}</td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-4">
                                <!-- Tampilkan Foto atau Placeholder jika kosong -->
                                @if($buku->gambar_sampul)
                                    <img src="{{ asset('storage/' . $buku->gambar_sampul) }}" alt="Sampul {{ $buku->judul }}" class="w-12 h-16 object-cover rounded shadow-sm border border-gray-200 shrink-0">
                                @else
                                    <div class="w-12 h-16 bg-gray-50 rounded flex items-center justify-center text-gray-400 border border-gray-200 shrink-0 shadow-sm">
                                        <i class="ph ph-image text-xl"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-bold text-gray-800">{{ $buku->judul }}</p>
                                    <div class="text-xs font-normal text-gray-500 mt-1">Rak: {{ $buku->rak }} | {{ ucfirst($buku->kategori) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-gray-600">{{ $buku->pengarang }}</td>
                        <td class="py-4 px-6">
                            <span class="font-bold text-gray-800">{{ $buku->stok }}</span>
                            <span class="text-xs text-gray-500">Buku</span>
                        </td>
                        <td class="py-4 px-6">
                            <!-- Logika If-Else untuk badge status stok -->
                            @if($buku->stok > 0)
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">Tersedia</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">Kosong</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Tombol Detail (Mata) -->
                                <a href="{{ route('buku.show', $buku->id) }}" class="p-2 text-teal-600 hover:bg-teal-50 rounded-lg transition-colors" title="Lihat Detail">
                                    <i class="ph ph-eye text-lg"></i>
                                </a>
                                <!-- Tombol Edit (Pensil) -->
                                <a href="{{ route('buku.edit', $buku->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <i class="ph ph-pencil-simple text-lg"></i>
                                </a>

                                <!-- Tombol Hapus (Tempat Sampah) dengan Modal Alpine.js -->
                                <div x-data="{ showDeleteModal: false }" class="inline-block">
                                    <button @click="showDeleteModal = true" type="button" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <i class="ph ph-trash text-lg"></i>
                                    </button>

                                    <!-- Modal Konfirmasi Hapus -->
                                    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[99] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                                        <div @click.away="showDeleteModal = false" class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl transform transition-all text-left">
                                            <div class="flex items-center gap-4 mb-4">
                                                <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xl shrink-0">
                                                    <i class="ph ph-warning-circle"></i>
                                                </div>
                                                <div>
                                                    <h3 class="font-bold text-gray-900 text-base">Hapus Buku?</h3>
                                                    <p class="text-xs text-gray-500 mt-1">Data buku ini akan dihapus permanen dan tidak bisa dikembalikan.</p>
                                                </div>
                                            </div>
                                            <div class="flex justify-end gap-3 mt-6">
                                                <button @click="showDeleteModal = false" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50">Batal</button>
                                                <form action="{{ route('buku.destroy', $buku->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700">Ya, Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Tombol Hapus -->

                            </div>
                        </td>
                    </tr>
                    @empty
                    <!-- Tampilan Jika Database Kosong -->
                    <tr>
                        <td colspan="6" class="py-20 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i class="ph ph-book-open text-6xl mb-4 text-gray-300"></i>
                                <p class="text-sm font-medium text-gray-500">Belum ada data buku</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links (Otomatis dibuat oleh Laravel dengan gaya Tailwind) -->
        <div class="p-4 border-t border-gray-100">
            {{ $bukus->links() }}
        </div>
    </div>

    <!-- Footer Baru: Putih, Kecil, dan Border Tipis -->
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

    </div> <!-- End of Wrapper -->

</x-admin-layout>
