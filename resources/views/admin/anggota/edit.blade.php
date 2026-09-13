<x-admin-layout>
    <x-slot:title>
        Edit Anggota - Sistem Perpustakaan
    </x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Data Anggota</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi profil siswa di perpustakaan</p>
        </div>
        <a href="{{ route('anggota.index') }}" class="inline-flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
            <i class="ph ph-arrow-left text-lg"></i>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        <div class="p-6 sm:p-8">
            <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- NIS -->
                    <div>
                        <label for="nis" class="block text-sm font-semibold text-gray-700 mb-2">Nomor Induk Siswa (NIS/NISN) <span class="text-red-500">*</span></label>
                        <!-- Menambahkan maxlength="10" -->
                        <input type="text" id="nis" name="nis" value="{{ old('nis', $anggota->nis) }}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 font-mono" required>
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $anggota->nama_lengkap) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800" required>
                    </div>

                    <!-- Kelas (Diubah jadi Dropdown) -->
                    <div>
                        <label for="kelas" class="block text-sm font-semibold text-gray-700 mb-2">Kelas <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="kelas" name="kelas" class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-700 bg-gray-50 hover:bg-gray-100 cursor-pointer" required>
                                <option value="" disabled class="bg-gray-200 text-gray-500 font-semibold">Pilih Kelas</option>
                                @php $abjadKategori = ['A', 'B', 'C']; @endphp
                                @for($i = 1; $i <= 6; $i++)
                                    @foreach($abjadKategori as $huruf)
                                        @php $nilaiKelas = $i . $huruf; @endphp
                                        <option value="{{ $nilaiKelas }}" class="bg-gray-50 text-gray-700 text-sm" {{ old('kelas', $anggota->kelas) == $nilaiKelas ? 'selected' : '' }}>Kelas {{ $nilaiKelas }}</option>
                                    @endforeach
                                @endfor
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
                            <select id="jenis_kelamin" name="jenis_kelamin" class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-700 bg-gray-50 hover:bg-gray-100 cursor-pointer" required>
                                <option value="L" class="bg-gray-50 text-gray-700 text-sm" {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                                <option value="P" class="bg-gray-50 text-gray-700 text-sm" {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="ph ph-caret-down text-gray-500"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap (Opsional)</label>
                        <textarea id="alamat" name="alamat" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 resize-none">{{ old('alamat', $anggota->alamat) }}</textarea>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status Anggota <span class="text-red-500">*</span></label>
                        <div class="relative sm:w-2/3 lg:max-w-[200px]">
                            <select id="status" name="status" class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-700 bg-gray-50 hover:bg-gray-100 cursor-pointer" required>
                                <option value="Aktif" class="bg-gray-50 text-gray-700 text-sm" {{ old('status', $anggota->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" class="bg-gray-50 text-gray-700 text-sm" {{ old('status', $anggota->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="ph ph-caret-down text-gray-500"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('anggota.index') }}" class="w-full sm:w-auto text-center px-6 py-3 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors">Batal</a>
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm flex justify-center gap-2">
                        <i class="ph ph-pencil-simple text-lg"></i> Perbarui Data Anggota
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
