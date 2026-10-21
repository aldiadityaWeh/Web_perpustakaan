<x-admin-layout>
    <x-slot:title>
        Tambah Buku Baru - Sistem Perpustakaan
    </x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-slate-100 transition-colors">Tambah Buku Baru</h1>
            <p class="text-sm text-gray-500 dark:text-slate-400 mt-1 transition-colors">Masukkan detail informasi buku ke dalam sistem</p>
        </div>
        <a href="{{ route('buku.index') }}" class="inline-flex items-center gap-2 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-300 px-4 py-2 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
            <i class="ph ph-arrow-left text-lg"></i>
            Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden max-w-4xl transition-colors">

        <div class="p-6 sm:p-8">
            <form action="{{ route('buku.store') }}" method="POST" id="formTambahBuku" enctype="multipart/form-data">
                @csrf

                <!-- Pesan Error Validasi -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 rounded-xl text-red-600 dark:text-red-400 text-sm transition-colors">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Upload Foto Sampul -->
                <div class="mb-6 p-5 border border-dashed border-gray-300 dark:border-slate-600 rounded-xl bg-gray-50/50 dark:bg-slate-900/50 transition-colors">
                    <label for="gambar_sampul" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Foto Sampul Buku (Opsional)</label>
                    <input type="file" id="gambar_sampul" name="gambar_sampul" accept="image/*" class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition-colors text-sm text-gray-800 dark:text-slate-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 dark:file:bg-purple-500/20 file:text-purple-700 dark:file:text-purple-400 hover:file:bg-purple-100 dark:hover:file:bg-purple-500/30 cursor-pointer">
                    <p class="text-xs text-gray-500 dark:text-slate-500 mt-2">Format yang diizinkan: JPG, JPEG, PNG. Maksimal ukuran: 2MB.</p>
                </div>

                <!-- Judul Buku -->
                <div class="mb-6">
                    <label for="judul" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Judul Buku <span class="text-red-500">*</span></label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Laskar Pelangi" class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition-colors text-sm text-gray-800 dark:text-slate-200 placeholder-gray-400 dark:placeholder-slate-500" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- ISBN -->
                    <div>
                        <label for="isbn" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">ISBN (13 Digit) <span class="text-red-500">*</span></label>
                        <!-- oninput memaksa pengguna hanya bisa mengetikkan angka -->
                        <input type="text" id="isbn" name="isbn" value="{{ old('isbn') }}" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Ketik 13 digit angka ISBN" class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition-colors text-sm text-gray-800 dark:text-slate-200 placeholder-gray-400 dark:placeholder-slate-500 font-mono" required>
                    </div>

                    <!-- Pengarang -->
                    <div>
                        <label for="pengarang" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Pengarang <span class="text-red-500">*</span></label>
                        <input type="text" id="pengarang" name="pengarang" value="{{ old('pengarang') }}" placeholder="Nama Penulis" class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition-colors text-sm text-gray-800 dark:text-slate-200 placeholder-gray-400 dark:placeholder-slate-500" required>
                    </div>

                    <!-- Penerbit -->
                    <div>
                        <label for="penerbit" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Penerbit <span class="text-red-500">*</span></label>
                        <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit') }}" placeholder="Nama Penerbit" class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition-colors text-sm text-gray-800 dark:text-slate-200 placeholder-gray-400 dark:placeholder-slate-500" required>
                    </div>

                    <!-- Tahun Terbit -->
                    <div>
                        <label for="tahun_terbit" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Tahun Terbit <span class="text-red-500">*</span></label>
                        <div class="relative sm:w-2/3 lg:max-w-[200px]">
                            <select id="tahun_terbit" name="tahun_terbit" class="appearance-none w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-gray-50 dark:bg-slate-900 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition-colors text-sm text-gray-700 dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800 cursor-pointer" required>
                                @php $currentYear = date('Y'); @endphp
                                @for($i = $currentYear; $i >= 1980; $i--)
                                    <option value="{{ $i }}" class="bg-gray-50 dark:bg-slate-800 text-gray-700 dark:text-slate-200" {{ old('tahun_terbit', $currentYear) == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="ph ph-caret-down text-gray-500 dark:text-slate-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori (DDC - Dewey Decimal Classification) -->
                    <div>
                        <label for="kategori" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Kategori (Standar DDC) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="kategori" name="kategori" class="appearance-none w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-gray-50 dark:bg-slate-900 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition-colors text-sm text-gray-700 dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800 cursor-pointer" required>
                                <option value="" disabled class="bg-gray-200 dark:bg-slate-700 text-gray-500 font-semibold" {{ old('kategori') ? '' : 'selected' }}>Pilih Klasifikasi Buku</option>
                                @php
                                    $kategoris = [
                                        '000' => '000 - Komputer, Informasi & Referensi',
                                        '100' => '100 - Filsafat & Psikologi',
                                        '200' => '200 - Agama',
                                        '300' => '300 - Ilmu Sosial',
                                        '400' => '400 - Bahasa',
                                        '500' => '500 - Sains & Matematika',
                                        '600' => '600 - Teknologi & Ilmu Terapan',
                                        '700' => '700 - Kesenian, Hiburan & Olahraga',
                                        '800' => '800 - Kesusastraan (Sastra)',
                                        '900' => '900 - Sejarah & Geografi',
                                    ];
                                @endphp
                                @foreach($kategoris as $value => $label)
                                    <option value="{{ $value }}" class="bg-gray-50 dark:bg-slate-800 text-gray-700 dark:text-slate-200" {{ old('kategori') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="ph ph-caret-down text-gray-500 dark:text-slate-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Jumlah Buku -->
                    <div>
                        <label for="stok" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Jumlah Buku (Stok) <span class="text-red-500">*</span></label>
                        <input type="number" id="stok" name="stok" value="{{ old('stok', 1) }}" min="1" placeholder="Stok tersedia" class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition-colors text-sm text-gray-800 dark:text-slate-200 placeholder-gray-400 dark:placeholder-slate-500" required>
                    </div>

                    <!-- Lokasi Rak -->
                    <div class="md:col-span-2">
                        <label for="rak" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Lokasi Rak <span class="text-red-500">*</span></label>
                        <input type="text" id="rak" name="rak" value="{{ old('rak') }}" placeholder="Contoh: Rak A1" class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition-colors text-sm text-gray-800 dark:text-slate-200 placeholder-gray-400 dark:placeholder-slate-500" required>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 dark:border-slate-700 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('buku.index') }}" class="w-full sm:w-auto text-center px-6 py-3 text-sm font-semibold text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 text-sm font-semibold text-white bg-purple-600 border border-transparent rounded-xl hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition-colors shadow-sm flex items-center justify-center gap-2">
                        <i class="ph ph-floppy-disk text-lg"></i>
                        Simpan Data Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
