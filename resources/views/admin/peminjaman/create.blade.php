<x-admin-layout>
    <x-slot:title>
        Tambah Peminjaman - Sistem Perpustakaan
    </x-slot:title>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Proses Peminjaman</h1>
            <p class="text-sm text-gray-500 mt-1">Catat transaksi peminjaman buku oleh siswa</p>
        </div>
        <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
            <i class="ph ph-arrow-left text-lg"></i>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-5xl">
        <div class="p-6 sm:p-8">
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- X-DATA UNTUK FILTER ANGGOTA BERDASARKAN KELAS -->
                <div class="mb-6" x-data="{
                    semuaAnggota: {{ $anggotas->map(fn($a) => ['id' => $a->id, 'nama' => $a->nama_lengkap, 'nis' => $a->nis, 'kelas' => $a->kelas])->toJson() }},
                    kelasDipilih: '{{ old('kelas_filter') ?? '' }}',
                    anggotaDipilih: '{{ old('anggota_id') ?? '' }}',
                    daftarKelas: ['1A','1B','1C','2A','2B','2C','3A','3B','3C','4A','4B','4C','5A','5B','5C','6A','6B','6C']
                }">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-5 border border-purple-100 bg-purple-50/30 rounded-2xl">

                        <!-- 1. Pilih Kelas (Filter) -->
                        <div>
                            <label for="kelas_filter" class="block text-sm font-semibold text-gray-700 mb-2">1. Filter Kelas Siswa <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select id="kelas_filter" name="kelas_filter" x-model="kelasDipilih" @change="anggotaDipilih = ''" class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-700 bg-white hover:bg-gray-50 cursor-pointer">
                                    <option value="" disabled class="font-bold">-- Pilih Kelas --</option>
                                    <template x-for="kls in daftarKelas">
                                        <option :value="kls" x-text="'Kelas ' + kls" class="text-sm"></option>
                                    </template>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="ph ph-caret-down text-gray-500"></i>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Pilih Anggota -->
                        <div>
                            <label for="anggota_id" class="block text-sm font-semibold text-gray-700 mb-2">2. Nama Peminjam (Siswa) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <!-- Kotak terkunci jika kelas belum dipilih -->
                                <select id="anggota_id" name="anggota_id" x-model="anggotaDipilih" :disabled="!kelasDipilih" class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed bg-white cursor-pointer shadow-sm" required>
                                    <option value="" disabled class="font-bold">-- Pilih Siswa --</option>

                                    <!-- Menampilkan siswa hanya yang kelasnya cocok -->
                                    <template x-for="anggota in semuaAnggota.filter(a => a.kelas === kelasDipilih)" :key="anggota.id">
                                        <option :value="anggota.id" x-text="anggota.nama + ' (NIS: ' + anggota.nis + ')'"></option>
                                    </template>

                                    <!-- Peringatan jika kelas tersebut kosong (tidak ada siswa aktif) -->
                                    <template x-if="kelasDipilih && semuaAnggota.filter(a => a.kelas === kelasDipilih).length === 0">
                                        <option value="" disabled class="text-red-500 font-bold">-- Tidak ada siswa aktif di kelas ini --</option>
                                    </template>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="ph ph-caret-down text-gray-500"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Tanggal Pinjam -->
                    <div>
                        <label for="tanggal_pinjam" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pinjam <span class="text-red-500">*</span></label>
                        <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition text-sm text-gray-800" required>
                    </div>

                    <!-- Tanggal Kembali -->
                    <div>
                        <label for="tanggal_kembali" class="block text-sm font-semibold text-gray-700 mb-2">Batas Tanggal Kembali <span class="text-red-500">*</span></label>
                        <!-- Otomatis diatur 7 hari dari sekarang sebagai default -->
                        <input type="date" id="tanggal_kembali" name="tanggal_kembali" value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+7 days'))) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition text-sm text-gray-800" required>
                    </div>
                </div>

                <!-- x-data mendefinisikan array data lokal dari PHP agar bisa disaring secara instan dengan JS -->
                <div class="mb-8 pt-6 border-t border-gray-100" x-data="{
                    semuaBuku: {{ $bukus->map(fn($b) => ['id' => $b->id, 'judul' => $b->judul, 'stok' => $b->stok, 'kategori' => $b->kategori])->toJson() }},
                    kategoriList: [
                        { id: '000', nama: '000 - Komputer & Info' },
                        { id: '100', nama: '100 - Filsafat & Psikologi' },
                        { id: '200', nama: '200 - Agama' },
                        { id: '300', nama: '300 - Ilmu Sosial' },
                        { id: '400', nama: '400 - Bahasa' },
                        { id: '500', nama: '500 - Sains & MTK' },
                        { id: '600', nama: '600 - Teknologi Terapan' },
                        { id: '700', nama: '700 - Seni & Olahraga' },
                        { id: '800', nama: '800 - Kesusastraan' },
                        { id: '900', nama: '900 - Sejarah & Geografi' }
                    ],
                    rows: [{ id: Date.now(), kategori_id: '', buku_id: '' }],
                    addRow() { this.rows.push({ id: Date.now(), kategori_id: '', buku_id: '' }) },
                    removeRow(idToRemove) { this.rows = this.rows.filter(row => row.id !== idToRemove) }
                }">
                    <div class="flex items-center justify-between mb-4">
                        <label class="block text-sm font-semibold text-gray-700">Daftar Buku yang Dipinjam <span class="text-red-500">*</span></label>

                        <!-- Tombol Tambah Baris Buku -->
                        <button type="button" @click="addRow()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-purple-50 text-purple-700 hover:bg-purple-100 rounded-lg text-xs font-bold transition-colors">
                            <i class="ph ph-plus-circle text-base"></i> Tambah Buku Lain
                        </button>
                    </div>

                    <!-- Tempat Baris Buku Muncul -->
                    <div class="flex flex-col gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-200">
                        <template x-for="(row, index) in rows" :key="row.id">
                            <div class="flex flex-col md:flex-row md:items-center gap-3 bg-white p-3 rounded-xl border border-gray-100 shadow-sm relative">
                                <!-- Kotak Nomor -->
                                <div class="w-8 h-8 shrink-0 bg-purple-100 text-purple-700 rounded-lg flex items-center justify-center font-bold text-sm hidden md:flex" x-text="index + 1"></div>

                                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-3 w-full">
                                    <div class="relative w-full">
                                        <!-- Saat kategori diganti, pilihan buku otomatis di-reset jadi kosong -->
                                        <select x-model="row.kategori_id" @change="row.buku_id = ''" class="appearance-none w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-700 bg-gray-50 hover:bg-gray-100 cursor-pointer">
                                            <option value="" disabled selected class="font-bold">1. Pilih Kategori</option>
                                            <template x-for="kat in kategoriList" :key="kat.id">
                                                <option :value="kat.id" x-text="kat.nama"></option>
                                            </template>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <i class="ph ph-caret-down text-gray-500"></i>
                                        </div>
                                    </div>

                                    <div class="relative w-full">
                                        <!-- Select ini terkunci (disabled) jika kategori belum dipilih -->
                                        <select x-model="row.buku_id" name="buku_id[]" :disabled="!row.kategori_id" class="appearance-none w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed bg-white cursor-pointer" required>
                                            <option value="" disabled selected class="font-bold">2. Pilih Buku Tersedia</option>

                                            <!-- Looping hanya untuk buku yang kategorinya sama dengan pilihan di atas -->
                                            <template x-for="buku in semuaBuku.filter(b => b.kategori === row.kategori_id)" :key="buku.id">
                                                <option :value="buku.id" x-text="buku.judul + ' (Sisa: ' + buku.stok + ')'"></option>
                                            </template>

                                            <!-- Tampilkan pesan ini jika di kategori tersebut stok bukunya kosong semua -->
                                            <template x-if="row.kategori_id && semuaBuku.filter(b => b.kategori === row.kategori_id).length === 0">
                                                <option value="" disabled class="text-red-500 font-bold">-- Buku di kategori ini sedang kosong --</option>
                                            </template>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <i class="ph ph-caret-down text-gray-500"></i>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" @click="removeRow(row.id)" x-show="rows.length > 1" class="absolute -top-2 -right-2 md:static md:w-10 md:h-10 shrink-0 flex items-center justify-center text-red-500 bg-white border border-red-100 md:border-transparent hover:bg-red-50 hover:text-red-600 rounded-full md:rounded-xl transition-colors shadow-sm md:shadow-none p-1.5 md:p-0 z-10" title="Hapus Baris">
                                    <i class="ph ph-trash text-base md:text-lg"></i>
                                </button>
                                <!-- Spacer desktop -->
                                <div class="w-10 h-10 shrink-0 hidden md:block" x-show="rows.length === 1"></div>
                            </div>
                        </template>
                    </div>
                    <p class="text-[11px] text-gray-400 mt-3"><i class="ph ph-info mr-1"></i> Pilih Kategori DDC terlebih dahulu untuk menampilkan daftar buku. Stok akan dikurangi otomatis setelah disimpan.</p>
                </div>

                <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('peminjaman.index') }}" class="w-full sm:w-auto text-center px-6 py-3 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 text-sm font-semibold text-white bg-purple-600 border border-transparent rounded-xl hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors shadow-sm flex items-center justify-center gap-2">
                        <i class="ph ph-handshake text-lg"></i>
                        Proses Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
