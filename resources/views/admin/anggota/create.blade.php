<x-admin-layout>
    <x-slot:title>
        Tambah Anggota Baru - Sistem Perpustakaan
    </x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Anggota Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Masukkan detail informasi anggota ke dalam sistem</p>
        </div>
        <a href="{{ route('anggota.index') }}" class="inline-flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
            <i class="ph ph-arrow-left text-lg"></i>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        
        <div class="p-6 sm:p-8">
            <form action="#" method="POST">
                @csrf
                
                <!-- Layout Grid 2 Kolom -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    
                    <!-- NIS -->
                    <div>
                        <label for="nis" class="block text-sm font-semibold text-gray-700 mb-2">NIS <span class="text-red-500">*</span></label>
                        <input type="text" id="nis" name="nis" placeholder="Contoh: 2000100" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 placeholder-gray-400" required>
                    </div>
                    
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Contoh: Agung Prastiyo" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 placeholder-gray-400" required>
                    </div>

                    <!-- Kelas -->
                    <div>
                        <label for="kelas" class="block text-sm font-semibold text-gray-700 mb-2">Kelas <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="kelas" name="kelas" class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 bg-white cursor-pointer" required>
                                <option value="" disabled selected>Pilih Kelas</option>
                                <optgroup label="Kelas 1">
                                    <option value="1A">Kelas 1A</option>
                                    <option value="1B">Kelas 1B</option>
                                    <option value="1C">Kelas 1C</option>
                                </optgroup>
                                <optgroup label="Kelas 2">
                                    <option value="2A">Kelas 2A</option>
                                    <option value="2B">Kelas 2B</option>
                                    <option value="2C">Kelas 2C</option>
                                </optgroup>
                                <optgroup label="Kelas 3">
                                    <option value="3A">Kelas 3A</option>
                                    <option value="3B">Kelas 3B</option>
                                    <option value="3C">Kelas 3C</option>
                                </optgroup>
                                <optgroup label="Kelas 4">
                                    <option value="4A">Kelas 4A</option>
                                    <option value="4B">Kelas 4B</option>
                                    <option value="4C">Kelas 4C</option>
                                </optgroup>
                                <optgroup label="Kelas 5">
                                    <option value="5A">Kelas 5A</option>
                                    <option value="5B">Kelas 5B</option>
                                    <option value="5C">Kelas 5C</option>
                                </optgroup>
                                <optgroup label="Kelas 6">
                                    <option value="6A">Kelas 6A</option>
                                    <option value="6B">Kelas 6B</option>
                                    <option value="6C">Kelas 6C</option>
                                </optgroup>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="ph ph-caret-down text-gray-500"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="jenis_kelamin" name="jenis_kelamin" class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 bg-white cursor-pointer" required>
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="ph ph-caret-down text-gray-500"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap..." class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 placeholder-gray-400 resize-none"></textarea>
                    </div>

                    <!-- Status -->
                    <div class="md:col-span-2 md:w-1/2 md:pr-3">
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="status" name="status" class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 bg-white cursor-pointer" required>
                                <option value="Aktif" selected>Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="ph ph-caret-down text-gray-500"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('anggota.index') }}" class="w-full sm:w-auto text-center px-6 py-3 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 text-sm font-semibold text-white bg-purple-600 border border-transparent rounded-xl hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors shadow-sm flex items-center justify-center gap-2">
                        <i class="ph ph-floppy-disk text-lg"></i>
                        Simpan Data Anggota
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-admin-layout>