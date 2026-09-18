<x-admin-layout>
    <x-slot:title>
        Data Buku - Sistem Perpustakaan
    </x-slot:title>

    <!-- Menggunakan flex-1 tanpa h-full agar tabel bisa memanjang ke bawah dan scroll normal -->
    <div class="flex flex-col flex-1">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Buku</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola inventaris koleksi buku perpustakaan</p>

            <div class="mt-2 inline-block bg-blue-100 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-bold border border-blue-200">
                <i class="ph ph-database mr-1"></i> Total Asli di Database saat ini: {{ \App\Models\Buku::count() }} Data
            </div>
        </div>

        <a href="{{ route('buku.create') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
            <i class="ph ph-plus text-lg"></i>
            Tambah Buku
        </a>
    </div>

    <!-- Kolom Pencarian Buku -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <form id="searchFormBuku" data-url="{{ route('buku.index') }}" action="{{ route('buku.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="ph ph-magnifying-glass text-gray-400 text-lg"></i>
                </div>
                <input type="text" id="searchInputBuku" name="search" value="{{ request('search') }}" autocomplete="off" placeholder="Ketik Judul Buku, Pengarang, ISBN, atau Kategori..."
                    class="pl-11 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-700 placeholder-gray-400">
            </div>
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-sm focus:outline-none shrink-0 flex items-center gap-2">
                <span id="searchLabelBuku">Cari Data</span>
                <i id="loadingSpinnerBuku" class="ph ph-spinner-gap animate-spin hidden text-lg"></i>
            </button>
        </form>
    </div>

    <!-- Target JS Table Container Buku -->
    <div id="table-container-buku" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8 transition-opacity duration-300">

        @if(session('success'))
            <div class="bg-emerald-50 border-b border-emerald-100 p-4 flex items-center gap-3 text-emerald-700 text-sm font-medium">
                <i class="ph ph-check-circle text-xl"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse min-w-[800px]">

                <thead class="bg-purple-50 sticky top-0 z-10 outline outline-1 outline-gray-200">
                    <tr class="text-gray-500 text-[11px] font-bold uppercase tracking-wider">
                        <th class="py-4 px-6 w-16 text-center">No</th>
                        <th class="py-4 px-6">Judul Buku</th>
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-6">Stok</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($bukus as $buku)
                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors text-sm">
                        <td class="py-4 px-6 text-gray-600 font-medium text-center">{{ $bukus->firstItem() + $loop->index }}</td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <!-- FITUR FOTO SAMPUL BUKU (Dengan Fallback Error) -->
                                @if($buku->gambar_sampul)
                                    <img src="{{ asset('storage/' . $buku->gambar_sampul) }}" alt="Sampul {{ $buku->judul }}" onerror="this.onerror=null;this.src='https://placehold.co/40x56/f3f4f6/a1a1aa?text=X'" class="w-10 h-14 object-cover rounded-lg shadow-sm border border-gray-200 shrink-0">
                                @else
                                    <div class="w-10 h-14 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center font-bold border border-blue-100 shrink-0">
                                        <i class="ph ph-image text-xl"></i>
                                    </div>
                                @endif
                                <div>
                                    <span class="font-bold text-gray-800 block">{{ $buku->judul }}</span>
                                    <span class="text-xs text-gray-400">Pengarang: {{ $buku->pengarang }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-gray-600">
                            @php
                                // Menerjemahkan Kode DDC menjadi Nama Kategori
                                $kategoriLabel = [
                                    '000' => 'Komputer & Informasi',
                                    '100' => 'Filsafat & Psikologi',
                                    '200' => 'Agama',
                                    '300' => 'Ilmu Sosial',
                                    '400' => 'Bahasa',
                                    '500' => 'Sains & Matematika',
                                    '600' => 'Teknologi Terapan',
                                    '700' => 'Seni & Olahraga',
                                    '800' => 'Kesusastraan',
                                    '900' => 'Sejarah & Geografi',
                                ];
                                $namaKategori = $kategoriLabel[$buku->kategori] ?? ucfirst($buku->kategori);
                            @endphp
                            <span class="px-2.5 py-1 bg-gray-100 text-gray-700 text-[11px] font-bold rounded-md whitespace-nowrap border border-gray-200">
                                {{ $namaKategori }}
                            </span>
                        </td>
                        <td class="py-4 px-6 font-bold text-gray-800">
                            {{ $buku->stok }} <span class="text-xs font-normal text-gray-400">Pcs</span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('buku.show', $buku->id) }}" class="p-2 text-teal-600 hover:bg-teal-50 rounded-lg transition-colors" title="Lihat Detail">
                                    <i class="ph ph-eye text-lg"></i>
                                </a>
                                <a href="{{ route('buku.edit', $buku->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <i class="ph ph-pencil-simple text-lg"></i>
                                </a>

                                <div x-data="{ showDeleteModal: false }" class="inline-block">
                                    <button @click="showDeleteModal = true" type="button" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <i class="ph ph-trash text-lg"></i>
                                    </button>

                                    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[99] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 text-left">
                                        <div @click.away="showDeleteModal = false" class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl transform transition-all">
                                            <div class="flex items-center gap-4 mb-4">
                                                <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xl shrink-0">
                                                    <i class="ph ph-warning-circle"></i>
                                                </div>
                                                <div>
                                                    <h3 class="font-bold text-gray-900 text-base">Hapus Buku?</h3>
                                                    <p class="text-xs text-gray-500 mt-1">Data buku ini akan dihapus permanen.</p>
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
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center">
                            <div class="flex flex-col items-center justify-center -mt-4">
                                <div class="w-24 h-24 rounded-full bg-blue-50 border-8 border-white shadow-sm flex items-center justify-center mb-4">
                                    <i class="ph ph-book text-4xl text-blue-500 block leading-none"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800 mb-1">Data Buku Tidak Ditemukan</h3>
                                <p class="text-sm font-medium text-gray-500 mb-6">Pencarian tidak cocok dengan buku manapun.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- FITUR PAGINATION -->
        <div class="p-4 border-t border-gray-100">
            {{ $bukus->links() }}
        </div>
    </div>

   <footer class="bg-white border-t border-gray-200 text-gray-500 py-4 px-6 rounded-xl flex flex-col sm:flex-row justify-between items-center gap-2 text-xs mt-auto shadow-sm">
        <div class="text-center sm:text-left">
            <p class="font-medium text-gray-600 mb-0.5">Sistem Perpustakaan Sekolah</p>
            <p>&copy; 2026 - Sistem Dibangun oleh Aldi Aditya</p>
        </div>
    </footer>

    </div>

    <!-- Memanggil Script Eksternal Live Search Buku -->
    <script src="{{ asset('js/search-buku.js') }}"></script>
</x-admin-layout>
