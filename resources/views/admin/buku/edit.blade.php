<x-admin-layout>
    <x-slot:title>
        Edit Data Buku - Sistem Perpustakaan
    </x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Data Buku</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi untuk buku: <span class="font-bold text-purple-600">{{ $buku->judul }}</span></p>
        </div>
        <a href="{{ route('buku.index') }}" class="inline-flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
            <i class="ph ph-arrow-left text-lg"></i>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">

        <div class="p-6 sm:p-8">
            <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Wajib untuk proses Edit di Laravel -->

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
                <div class="mb-6 flex flex-col sm:flex-row gap-6 items-start p-5 border border-dashed border-gray-300 rounded-xl bg-gray-50/50">
                    @if($buku->gambar_sampul)
                        <img src="{{ asset('storage/' . $buku->gambar_sampul) }}" alt="Sampul Lama" class="w-24 h-32 object-cover rounded-lg shadow-sm border border-gray-200 shrink-0">
                    @else
                        <div class="w-24 h-32 bg-gray-100 rounded-lg flex flex-col items-center justify-center text-gray-400 border border-gray-200 shrink-0">
                            <i class="ph ph-image text-3xl mb-1"></i>
                            <span class="text-[10px]">Tanpa Sampul</span>
                        </div>
                    @endif
                    <div class="w-full">
                        <label for="gambar_sampul" class="block text-sm font-semibold text-gray-700 mb-2">Ganti Foto Sampul (Opsional)</label>
                        <input type="file" id="gambar_sampul" name="gambar_sampul" accept="image/*" class="w-full px-4 py-2 border border-gray-300 bg-white rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 cursor-pointer">
                        <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah foto sampul. Maksimal: 2MB.</p>
                    </div>
                </div>

                <!-- Judul Buku -->
                <div class="mb-6">
                    <label for="judul" class="block text-sm font-semibold text-gray-700 mb-2">Judul Buku <span class="text-red-500">*</span></label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul', $buku->judul) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="isbn" class="block text-sm font-semibold text-gray-700 mb-2">ISBN <span class="text-red-500">*</span></label>
                        <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $buku->isbn) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800" required>
                    </div>

                    <div>
                        <label for="pengarang" class="block text-sm font-semibold text-gray-700 mb-2">Pengarang <span class="text-red-500">*</span></label>
                        <input type="text" id="pengarang" name="pengarang" value="{{ old('pengarang', $buku->pengarang) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800" required>
                    </div>

                    <div>
                        <label for="penerbit" class="block text-sm font-semibold text-gray-700 mb-2">Penerbit <span class="text-red-500">*</span></label>
                        <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800" required>
                    </div>

                    <div>
                        <label for="tahun_terbit" class="block text-sm font-semibold text-gray-700 mb-2">Tahun Terbit <span class="text-red-500">*</span></label>
                        <input type="number" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" min="1900" max="2099" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800" required>
                    </div>

                    <div>
                        <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="kategori" name="kategori" class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 bg-white cursor-pointer" required>
                                <option value="fiksi" {{ old('kategori', $buku->kategori) == 'fiksi' ? 'selected' : '' }}>Fiksi</option>
                                <option value="non-fiksi" {{ old('kategori', $buku->kategori) == 'non-fiksi' ? 'selected' : '' }}>Non-Fiksi</option>
                                <option value="pelajaran" {{ old('kategori', $buku->kategori) == 'pelajaran' ? 'selected' : '' }}>Buku Pelajaran</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="ph ph-caret-down text-gray-500"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="stok" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Buku (Stok) <span class="text-red-500">*</span></label>
                        <input type="number" id="stok" name="stok" value="{{ old('stok', $buku->stok) }}" min="0" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800" required>
                    </div>

                    <div class="md:col-span-2">
                        <label for="rak" class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Rak <span class="text-red-500">*</span></label>
                        <input type="text" id="rak" name="rak" value="{{ old('rak', $buku->rak) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800" required>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('buku.index') }}" class="w-full sm:w-auto text-center px-6 py-3 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 text-sm font-semibold text-white bg-blue-600 border border-transparent rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors shadow-sm flex items-center justify-center gap-2">
                        <i class="ph ph-check-circle text-lg"></i>
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-admin-layout>
