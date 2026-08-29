<x-admin-layout>
    <x-slot:title>
        Tambah Buku Baru - Sistem Perpustakaan
    </x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Buku Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Masukkan detail informasi buku ke dalam sistem</p>
        </div>
        <a href="{{ route('buku.index') }}" class="inline-flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
            <i class="ph ph-arrow-left text-lg"></i>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        
        <div class="p-6 sm:p-8">
            <form action="#" method="POST" id="formTambahBuku">
                @csrf
                
                <!-- Judul Buku (Full Width) -->
                <div class="mb-6">
                    <label for="judul" class="block text-sm font-semibold text-gray-700 mb-2">Judul Buku <span class="text-red-500">*</span></label>
                    <input type="text" id="judul" name="judul" placeholder="Contoh: Belajar Laravel 10 untuk Pemula" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 placeholder-gray-400" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- ISBN -->
                    <div>
                        <label for="isbn" class="block text-sm font-semibold text-gray-700 mb-2">ISBN <span class="text-red-500">*</span></label>
                        <input type="text" id="isbn" name="isbn" placeholder="Contoh: 978-602-1234-56-7" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 placeholder-gray-400" required>
                    </div>
                    
                    <!-- Pengarang -->
                    <div>
                        <label for="pengarang" class="block text-sm font-semibold text-gray-700 mb-2">Pengarang <span class="text-red-500">*</span></label>
                        <input type="text" id="pengarang" name="pengarang" placeholder="Nama Penulis" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 placeholder-gray-400" required>
                    </div>

                    <!-- Penerbit -->
                    <div>
                        <label for="penerbit" class="block text-sm font-semibold text-gray-700 mb-2">Penerbit <span class="text-red-500">*</span></label>
                        <input type="text" id="penerbit" name="penerbit" placeholder="Nama Penerbit" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 placeholder-gray-400" required>
                    </div>

                    <!-- Tahun Terbit -->
                    <div>
                        <label for="tahun_terbit" class="block text-sm font-semibold text-gray-700 mb-2">Tahun Terbit <span class="text-red-500">*</span></label>
                        <input type="number" id="tahun_terbit" name="tahun_terbit" min="1900" max="2099" placeholder="Contoh: 2024" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 placeholder-gray-400" required>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="kategori" name="kategori" class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 bg-white cursor-pointer" required>
                                <option value="" disabled selected>Pilih Kategori Buku</option>
                                <option value="fiksi">Fiksi</option>
                                <option value="non-fiksi">Non-Fiksi</option>
                                <option value="pelajaran">Buku Pelajaran</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="ph ph-caret-down text-gray-500"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Jumlah Buku -->
                    <div>
                        <label for="stok" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Buku <span class="text-red-500">*</span></label>
                        <input type="number" id="stok" name="stok" min="1" placeholder="Stok tersedia" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 placeholder-gray-400" required>
                    </div>

                    <!-- Lokasi Rak (Full Width pada Mobile, 1 Kolom pada Desktop jika ganjil) -->
                    <div class="md:col-span-2">
                        <label for="rak" class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Rak <span class="text-red-500">*</span></label>
                        <input type="text" id="rak" name="rak" placeholder="Contoh: Rak A1" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 placeholder-gray-400" required>
                    </div>
                </div>
                
                <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('buku.index') }}" class="w-full sm:w-auto text-center px-6 py-3 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 text-sm font-semibold text-white bg-purple-600 border border-transparent rounded-xl hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors shadow-sm flex items-center justify-center gap-2">
                        <i class="ph ph-floppy-disk text-lg"></i>
                        Simpan Data Buku
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-admin-layout>