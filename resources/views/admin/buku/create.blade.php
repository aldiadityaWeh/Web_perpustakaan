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
            <form action="{{ route('buku.store') }}" method="POST" id="formTambahBuku" enctype="multipart/form-data">
                @csrf

                <!-- Pesan Error Validasi -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Upload Foto Sampul -->
                <div class="mb-6 p-5 border border-dashed border-gray-300 rounded-xl bg-gray-50/50">
                    <label for="gambar_sampul" class="block text-sm font-semibold text-gray-700 mb-2">Foto Sampul Buku (Opsional)</label>
                    <input type="file" id="gambar_sampul" name="gambar_sampul" accept="image/*" class="w-full px-4 py-2.5 border border-gray-300 bg-white rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 cursor-pointer">
                    <p class="text-xs text-gray-500 mt-2">Format yang diizinkan: JPG, JPEG, PNG. Maksimal ukuran: 2MB.</p>
                </div>

                <!-- Judul Buku -->
                <div class="mb-6">
                    <label for="judul" class="block text-sm font-semibold text-gray-700 mb-2">Judul Buku <span class="text-red-500">*</span></label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Laskar Pelangi" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 placeholder-gray-400" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- ISBN -->
                    <div>
                        <label for="isbn" class="block text-sm font-semibold text-gray-700 mb-2">ISBN (13 Digit) <span class="text-red-500">*</span></label>
                        <!-- oninput memaksa pengguna hanya bisa mengetikkan angka -->
                        <input type="text" id="isbn" name="isbn" value="{{ old('isbn') }}" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Ketik 13 digit angka ISBN" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition text-sm text-gray-800 placeholder-gray-400 font-mono" required>
                    </div>

                    <!-- Pengarang -->
                    <div>
                        <label for="pengarang" class="block text-sm font-semibold text-gray-700 mb-2">Pengarang <span class="text-red-500">*</span></label>
                        <input type="text" id="pengarang" name="pengarang" value="{{ old('pengarang') }}" placeholder="Nama Penulis" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition text-sm text-gray-800 placeholder-gray-400" required>
                    </div>

                    <!-- Penerbit -->
                    <div>
                        <label for="penerbit" class="block text-sm font-semibold text-gray-700 mb-2">Penerbit <span class="text-red-500">*</span></label>
                        <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit') }}" placeholder="Nama Penerbit" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition text-sm text-gray-800 placeholder-gray-400" required>
                    </div>

                    <!-- Tahun Terbit (Diperkecil lebarnya) -->
                    <div>
                        <label for="tahun_terbit" class="block text-sm font-semibold text-gray-700 mb-2">Tahun Terbit <span class="text-red-500">*</span></label>
                        <!-- Mengganti w-full dengan pembatasan lebar: sm:w-1/2 atau lg:max-w-[200px] -->
                        <div class="relative sm:w-2/3 lg:max-w-[200px]">
                            <select id="tahun_terbit" name="tahun_terbit" class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-700 bg-gray-50 hover:bg-gray-100 cursor-pointer" required>
                                @php $currentYear = date('Y'); @endphp
                                @for($i = $currentYear; $i >= 1980; $i--)
                                    <option value="{{ $i }}" class="bg-gray-50 text-gray-700 text-sm" {{ old('tahun_terbit', $currentYear) == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="ph ph-caret-down text-gray-500"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori (DDC - Dewey Decimal Classification) -->
                    <div>
                        <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">Kategori (Standar DDC) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <!-- Mengubah warna kotak utama menjadi abu-abu (bg-gray-50) -->
                            <select id="kategori" name="kategori" class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-700 bg-gray-50 hover:bg-gray-100 cursor-pointer" required>
                                <option value="" disabled class="bg-gray-200 text-gray-500 text-sm font-semibold" {{ old('kategori') ? '' : 'selected' }}>Pilih Klasifikasi Buku</option>
                                <option value="000" class="bg-gray-50 text-gray-700 text-sm" {{ old('kategori') == '000' ? 'selected' : '' }}>000 - Komputer, Informasi & Referensi</option>
                                <option value="100" class="bg-gray-50 text-gray-700 text-sm" {{ old('kategori') == '100' ? 'selected' : '' }}>100 - Filsafat & Psikologi</option>
                                <option value="200" class="bg-gray-50 text-gray-700 text-sm" {{ old('kategori') == '200' ? 'selected' : '' }}>200 - Agama</option>
                                <option value="300" class="bg-gray-50 text-gray-700 text-sm" {{ old('kategori') == '300' ? 'selected' : '' }}>300 - Ilmu Sosial</option>
                                <option value="400" class="bg-gray-50 text-gray-700 text-sm" {{ old('kategori') == '400' ? 'selected' : '' }}>400 - Bahasa</option>
                                <option value="500" class="bg-gray-50 text-gray-700 text-sm" {{ old('kategori') == '500' ? 'selected' : '' }}>500 - Sains & Matematika</option>
                                <option value="600" class="bg-gray-50 text-gray-700 text-sm" {{ old('kategori') == '600' ? 'selected' : '' }}>600 - Teknologi & Ilmu Terapan</option>
                                <option value="700" class="bg-gray-50 text-gray-700 text-sm" {{ old('kategori') == '700' ? 'selected' : '' }}>700 - Kesenian, Hiburan & Olahraga</option>
                                <option value="800" class="bg-gray-50 text-gray-700 text-sm" {{ old('kategori') == '800' ? 'selected' : '' }}>800 - Kesusastraan (Sastra)</option>
                                <option value="900" class="bg-gray-50 text-gray-700 text-sm" {{ old('kategori') == '900' ? 'selected' : '' }}>900 - Sejarah & Geografi</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="ph ph-caret-down text-gray-500"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Jumlah Buku -->
                    <div>
                        <label for="stok" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Buku (Stok) <span class="text-red-500">*</span></label>
                        <input type="number" id="stok" name="stok" value="{{ old('stok', 1) }}" min="1" placeholder="Stok tersedia" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition text-sm text-gray-800 placeholder-gray-400" required>
                    </div>

                    <!-- Lokasi Rak -->
                    <div class="md:col-span-2">
                        <label for="rak" class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Rak <span class="text-red-500">*</span></label>
                        <input type="text" id="rak" name="rak" value="{{ old('rak') }}" placeholder="Contoh: Rak A1" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition text-sm text-gray-800 placeholder-gray-400" required>
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
