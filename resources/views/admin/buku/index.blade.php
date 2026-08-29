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
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-purple-50/50 border-b border-gray-100 text-gray-500 text-[11px] font-bold uppercase tracking-wider">
                        <th class="py-4 px-6">ISBN</th>
                        <th class="py-4 px-6">Judul Buku</th>
                        <th class="py-4 px-6">Pengarang</th>
                        <th class="py-4 px-6">Stok</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Empty State View -->
                    <tr>
                        <td colspan="6" class="py-20 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i class="ph ph-book-open text-6xl mb-4 text-gray-300"></i>
                                <p class="text-sm font-medium text-gray-500">Belum ada data buku</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="bg-purple-800 text-white p-5 rounded-xl flex flex-col sm:flex-row justify-between items-center gap-4 text-sm mt-auto shadow-md">
        <div class="text-center sm:text-left">
            <p class="font-bold text-base mb-0.5">Sistem Perpustakaan Sekolah</p>
            <p class="text-purple-300 text-xs tracking-wide">&copy; 2026 - Sistem Dibangun oleh Agung Prastiyo</p>
        </div>
        <div class="flex gap-5 text-xl">
            <a href="#" class="text-purple-200 hover:text-white transition-colors" title="Github">
                <i class="ph ph-github-logo"></i>
            </a>
            <a href="#" class="text-purple-200 hover:text-white transition-colors" title="Bantuan">
                <i class="ph ph-question"></i>
            </a>
        </div>
    </footer>
    
    </div> <!-- End of Wrapper -->

</x-admin-layout>