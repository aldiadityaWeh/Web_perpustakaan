<x-admin-layout>
    <x-slot:title>
        Tambah Peminjaman - Sistem Perpustakaan
    </x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Peminjaman Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Catat transaksi peminjaman buku oleh anggota</p>
        </div>
        <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
            <i class="ph ph-arrow-left text-lg"></i>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">

        <div class="p-6 sm:p-8">
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf

                <!-- Layout 1 Kolom memanjang ke bawah sesuai referensi -->
                <div class="flex flex-col gap-6 mb-8">

                    <!-- Pilih Buku -->
                    <div>
                        <label for="buku_id" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Buku <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="buku_id" name="buku_id" class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 bg-white cursor-pointer" required>
                                <option value="" disabled {{ old('buku_id') ? '' : 'selected' }}>Pilih buku yang akan dipinjam...</option>
                                @foreach($bukus as $buku)
                                    <option value="{{ $buku->id }}" {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                        {{ $buku->judul }} (Sisa Stok: {{ $buku->stok }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="ph ph-caret-down text-gray-500"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pilih Anggota -->
                    <div>
                        <label for="anggota_id" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Anggota <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="anggota_id" name="anggota_id" class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 bg-white cursor-pointer" required>
                                <option value="" disabled {{ old('anggota_id') ? '' : 'selected' }}>Pilih anggota peminjam...</option>
                                @foreach($anggotas as $anggota)
                                    <option value="{{ $anggota->id }}" {{ old('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                        {{ $anggota->nama_lengkap }} (Kelas {{ $anggota->kelas }}) - NIS: {{ $anggota->nis }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="ph ph-caret-down text-gray-500"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Jatuh Tempo -->
                    <div>
                        <label for="tanggal_jatuh_tempo" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Jatuh Tempo (Batas Kembali) <span class="text-red-500">*</span></label>
                        <input type="date" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo" value="{{ old('tanggal_jatuh_tempo', \Carbon\Carbon::now()->addDays(7)->format('Y-m-d')) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800" required>
                        <p class="text-xs text-gray-500 mt-2">*Otomatis diset 7 hari dari hari ini, Anda bisa mengubahnya jika perlu.</p>
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label for="catatan" class="block text-sm font-semibold text-gray-700 mb-2">Catatan (Opsional)</label>
                        <textarea id="catatan" name="catatan" rows="3" placeholder="Kondisi buku saat dipinjam, dll..." class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 placeholder-gray-400 resize-none"></textarea>
                    </div>

                </div>

                <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('peminjaman.index') }}" class="w-full sm:w-auto text-center px-6 py-3 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 text-sm font-semibold text-white bg-purple-600 border border-transparent rounded-xl hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors shadow-sm flex items-center justify-center gap-2">
                        <i class="ph ph-floppy-disk text-lg"></i>
                        Simpan Peminjaman
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-admin-layout>
