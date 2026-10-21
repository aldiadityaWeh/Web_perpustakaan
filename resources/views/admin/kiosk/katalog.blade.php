<!DOCTYPE html>
<html lang="id" x-data="kioskApp({{ $pengaturan->maksimal_buku_pinjam ?? 1 }})" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Katalog Buku - SIPUS Kiosk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Sembunyikan scrollbar tapi tetap bisa scroll */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
        html { scroll-behavior: smooth; }
        body { transition: background-color 0.3s ease, color 0.3s ease; }
    </style>
</head>
<body class="bg-[#f8fafd] dark:bg-slate-950 min-h-screen pb-32 font-sans transition-colors">

    <!-- HEADER (Sesuai Referensi) -->
    <header class="bg-[#5a86e5] dark:bg-slate-900 sticky top-0 z-40 shadow-sm transition-colors border-b border-transparent dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between">

            <!-- Kiri: Menu & Judul -->
            <div class="flex items-center gap-3 text-white">
                <button class="p-1 hover:bg-white/20 rounded transition-colors focus:outline-none hidden sm:block">
                    <i class="ph ph-list text-2xl"></i>
                </button>
                <h1 class="font-bold text-sm sm:text-base tracking-wide flex items-center gap-2">
                    <i class="ph ph-books sm:hidden text-xl"></i> Perpustakaan Digital
                </h1>
            </div>

            <!-- Kanan: Profil & Batal/Logout -->
            <div class="flex items-center gap-4 sm:gap-6">
                <!-- Tombol Tema Kiosk -->
                <button @click="toggleTheme()" class="text-white/80 hover:text-white transition-colors focus:outline-none flex items-center justify-center transform hover:scale-110" title="Ganti Mode Tema">
                    <i class="ph text-xl transition-all" :class="darkMode ? 'ph-sun-dim text-amber-400' : 'ph-moon-stars'"></i>
                </button>

                <div class="flex items-center gap-3 border-l border-white/20 pl-4 sm:pl-6">
                    <!-- Tombol Batal / Logout -->
                    <a href="{{ route('kiosk.index') }}" class="flex items-center gap-1.5 text-white/90 hover:text-white text-xs sm:text-sm font-semibold transition-colors">
                        <i class="ph ph-sign-out text-lg"></i>
                        <span class="hidden sm:inline">LOGOUT</span>
                    </a>
                    <!-- Info Siswa -->
                    <div class="flex items-center gap-2 bg-white/20 py-1.5 px-3 rounded-full border border-white/30 shadow-inner cursor-default">
                        <div class="w-6 h-6 bg-white text-[#5a86e5] dark:bg-slate-800 dark:text-blue-400 rounded-full flex items-center justify-center text-xs font-black">
                            {{ substr(session('kiosk_anggota_nama') ?? 'S', 0, 1) }}
                        </div>
                        <span class="text-xs sm:text-sm font-bold text-white max-w-[100px] sm:max-w-[150px] truncate">
                            {{ session('kiosk_anggota_nama') ?? 'Siswa' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @php
            $kategoriLabel = [
                '000' => 'Komputer & Informasi', '100' => 'Filsafat & Psikologi', '200' => 'Agama',
                '300' => 'Ilmu Sosial', '400' => 'Bahasa', '500' => 'Sains & Matematika',
                '600' => 'Teknologi Terapan', '700' => 'Seni & Olahraga', '800' => 'Kesusastraan',
                '900' => 'Sejarah & Geografi',
            ];
        @endphp

        <!-- HERO SECTION -->
        <div class="text-center max-w-4xl mx-auto mb-12">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-800 dark:text-slate-100 mb-3 tracking-tight transition-colors">
                Selamat Datang di SIPUS
            </h2>
            <p class="text-gray-500 dark:text-slate-400 text-sm sm:text-base transition-colors">
                Temukan buku yang ingin kamu pinjam disini.
            </p>

            <!-- SEARCH BAR TERPADU DENGAN OPTION DDC -->
            <div class="mt-8 flex flex-col md:flex-row items-center justify-center gap-3">

                <!-- Input Text Pencarian -->
                <div class="relative w-full md:w-[450px]">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="ph ph-magnifying-glass text-gray-400 text-lg"></i>
                    </div>
                    <input type="text" x-model="searchQuery" placeholder="Cari judul buku atau pengarang..."
                        class="w-full pl-11 pr-10 py-3.5 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-full shadow-sm focus:ring-2 focus:ring-[#5a86e5] outline-none text-sm font-medium text-gray-700 dark:text-slate-200 placeholder-gray-400 transition-colors">

                    <!-- Tombol Hapus Pencarian -->
                    <button x-show="searchQuery.length > 0" @click="searchQuery = ''" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-slate-300">
                        <i class="ph ph-x-circle text-lg"></i>
                    </button>
                </div>

                <!-- SIMBOL FILTER DDC (Di sebelah kanan input) -->
                <div class="relative" x-data="{ openFilter: false }">
                    <button @click="openFilter = !openFilter" @click.away="openFilter = false" type="button"
                        class="w-[52px] h-[52px] bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-full flex items-center justify-center shadow-sm transition-all focus:outline-none"
                        :class="searchCategory !== '' ? 'text-white bg-[#5a86e5] border-[#5a86e5] dark:bg-blue-600 dark:border-blue-600' : 'text-gray-500 hover:text-[#5a86e5] dark:text-slate-400 dark:hover:text-blue-400'"
                        title="Filter Kategori DDC">
                        <i class="ph text-xl transition-all" :class="searchCategory !== '' ? 'ph-funnel-fill' : 'ph-funnel'"></i>
                    </button>

                    <!-- Dropdown Menu Filter -->
                    <div x-show="openFilter" x-transition x-cloak
                        class="absolute right-0 md:left-1/2 md:-translate-x-1/2 mt-2 w-64 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-100 dark:border-slate-700 z-50 py-2 overflow-hidden text-left h-fit max-h-[60vh] overflow-y-auto no-scrollbar">
                        <div class="px-4 py-2 border-b border-gray-50 dark:border-slate-700/50">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kategori DDC</p>
                        </div>
                        <button @click="searchCategory = ''; openFilter = false" class="w-full px-4 py-2.5 text-left text-sm font-medium transition-colors hover:bg-gray-50 dark:hover:bg-slate-700" :class="searchCategory === '' ? 'text-[#5a86e5] font-bold bg-blue-50 dark:bg-slate-700/50' : 'text-gray-700 dark:text-slate-200'">
                            Semua Kategori
                        </button>
                        @foreach($kategoriLabel as $key => $label)
                            <button @click="searchCategory = '{{ $key }}'; openFilter = false" class="w-full px-4 py-2.5 text-left text-sm font-medium transition-colors hover:bg-gray-50 dark:hover:bg-slate-700 flex items-center justify-between group" :class="searchCategory === '{{ $key }}' ? 'text-[#5a86e5] font-bold bg-blue-50 dark:bg-slate-700/50' : 'text-gray-700 dark:text-slate-200'">
                                <span>{{ $key }} - {{ $label }}</span>
                                <i x-show="searchCategory === '{{ $key }}'" class="ph ph-check-circle text-lg"></i>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Tombol Cari -->
                <button class="w-full md:w-auto bg-[#5a86e5] hover:bg-blue-600 text-white px-8 h-[52px] rounded-full font-bold shadow-sm transition-colors flex items-center justify-center gap-2">
                    Cari
                </button>
            </div>
        </div>

        <!-- TAMPILAN BUKU (GRID MENYATU) -->
        <!-- Menggunakan x-show pada item untuk Live Search & Live Filter DDC Alpine.js -->
        <!-- GRID DIPERBAIKI: Jarak (gap) diperkecil agar kartu lebih padat -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4 lg:gap-5">
            @if(isset($bukus))
                @foreach($bukus as $kategori => $kumpulanBuku)
                    @foreach($kumpulanBuku as $buku)

                        <!-- KARTU BUKU DI DALAM KOTAK (CARD UTUH) -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col h-full relative group transition-all duration-300 hover:shadow-md"
                             x-show="matchesSearch('{{ addslashes($buku->judul) }}', '{{ addslashes($buku->pengarang) }}', '{{ $kategori }}')">

                            <!-- AREA GAMBAR DENGAN PADDING (Ruang kosong di sekeliling foto dikurangi agar tidak terlalu panjang) -->
                            <div class="p-2.5 sm:p-3 pb-0 relative">
                                <!-- Aspek rasio diubah dari 3/4 menjadi 4/5 agar gambar tidak terlalu memanjang ke bawah -->
                                <div class="relative w-full aspect-[4/5] bg-gray-100 dark:bg-slate-900 rounded-xl cursor-pointer overflow-hidden border border-gray-50 dark:border-slate-700"
                                     @click="toggleBook({{ $buku->id }})">

                                    @if($buku->gambar_sampul)
                                        <img src="{{ asset('storage/' . $buku->gambar_sampul) }}" onerror="this.onerror=null;this.src='https://placehold.co/300x400/f3f4f6/a1a1aa?text=Buku'" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" :class="isSelected({{ $buku->id }}) ? 'scale-105 opacity-80' : ''">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 dark:text-slate-600 transition-transform duration-500 group-hover:scale-105">
                                            <i class="ph ph-book-open text-3xl mb-1"></i>
                                        </div>
                                    @endif

                                    <!-- Overlay Gelap Saat Dipilih -->
                                    <div x-show="isSelected({{ $buku->id }})" x-transition class="absolute inset-0 bg-[#5a86e5]/20 dark:bg-blue-500/30 flex items-start justify-end p-2 z-10">
                                        <div class="bg-[#5a86e5] text-white rounded-full p-1 shadow-lg transform scale-110">
                                            <i class="ph ph-check-circle-fill text-lg"></i>
                                        </div>
                                    </div>

                                    <!-- Label Sisa Stok Kapsul -->
                                    <div class="absolute bottom-2 left-0 right-0 flex justify-center z-20">
                                        <span class="bg-gray-800/90 backdrop-blur-sm text-white text-[9px] px-2.5 py-1 rounded-full font-bold tracking-widest uppercase shadow-md border border-gray-600/50">
                                            Sisa: {{ $buku->stok }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Area Teks Detail Buku (Padding dan Margin Diperkecil) -->
                            <div class="flex flex-col flex-1 px-3 py-3">
                                <!-- Kategori Biru Kecil -->
                                <p class="text-[9px] font-bold text-[#5a86e5] dark:text-blue-400 uppercase tracking-widest mb-1 line-clamp-1 transition-colors">
                                    {{ $kategoriLabel[$kategori] ?? $kategori }}
                                </p>

                                <!-- Judul Tebal (Ukuran font dan jarak diperkecil) -->
                                <h4 class="font-extrabold text-gray-900 dark:text-slate-100 text-[12px] sm:text-[13px] leading-snug line-clamp-2 mb-0.5 min-h-[2.1rem] transition-colors" title="{{ $buku->judul }}">
                                    {{ $buku->judul }}
                                </h4>

                                <!-- Pengarang Samar -->
                                <p class="text-[10px] sm:text-[11px] text-gray-400 dark:text-slate-500 line-clamp-1 mb-2.5 transition-colors" title="{{ $buku->pengarang }}">
                                    {{ $buku->pengarang }}
                                </p>

                                <!-- Tombol Pilih -->
                                <div class="mt-auto">
                                    <button @click="toggleBook({{ $buku->id }})"
                                            class="w-full py-1.5 sm:py-2 rounded-xl text-xs font-bold transition-all duration-300 border flex items-center justify-center gap-1.5"
                                            :class="isSelected({{ $buku->id }})
                                                ? 'bg-red-50 text-red-500 border-red-200 hover:bg-red-500 hover:text-white dark:bg-red-500/10 dark:border-red-500/30'
                                                : 'bg-white text-[#5a86e5] border-gray-200 hover:border-[#5a86e5] dark:bg-slate-800 dark:border-slate-600 dark:hover:border-blue-500'">
                                        <i class="text-sm" :class="isSelected({{ $buku->id }}) ? 'ph ph-x-circle' : 'ph ph-plus-circle'"></i>
                                        <span x-text="isSelected({{ $buku->id }}) ? 'Batal' : 'Pilih'"></span>
                                    </button>
                                </div>
                            </div>

                        </div>

                    @endforeach
                @endforeach
            @endif
        </div>

        <!-- Pesan Jika Pencarian Tidak Ditemukan -->
        <div x-show="searchQuery.length > 0 || searchCategory !== ''" x-cloak class="mt-12 text-center text-gray-500 dark:text-slate-400 transition-colors">
            <p class="text-sm font-medium">Menampilkan hasil <span x-show="searchQuery.length > 0">untuk "<span class="font-bold text-[#5a86e5] dark:text-blue-400" x-text="searchQuery"></span>"</span> <span x-show="searchCategory !== ''">di kategori <span class="font-bold text-[#5a86e5] dark:text-blue-400" x-text="searchCategory"></span></span></p>
        </div>

    </main>

    <!-- Floating Action Bar (Cart) -->
    <div class="fixed bottom-0 inset-x-0 bg-white dark:bg-slate-900 border-t border-gray-200 dark:border-slate-800 shadow-[0_-10px_40px_rgba(0,0,0,0.08)] dark:shadow-[0_-10px_40px_rgba(0,0,0,0.5)] z-50 transform transition-all duration-300"
         :class="selectedIds.length > 0 ? 'translate-y-0' : 'translate-y-full'">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
           <div>
                <p class="text-sm text-gray-500 dark:text-slate-400 font-medium mb-0.5 transition-colors">Buku Terpilih</p>
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-extrabold text-[#5a86e5] dark:text-blue-400 transition-colors" x-text="selectedIds.length"></span>
                    <span class="text-gray-400 dark:text-slate-500 font-medium transition-colors">/ {{ $pengaturan->maksimal_buku_pinjam ?? 1 }} Maksimal</span>
                </div>
            </div>

            <!-- Form Tersembunyi untuk Submit (Ditambahkan event onsubmit) -->
            <form action="{{ route('kiosk.store') }}" method="POST" id="formSubmitPeminjaman" class="w-full sm:w-auto m-0" onsubmit="event.preventDefault(); konfirmasiSelesai()">
                @csrf
                <template x-for="id in selectedIds">
                    <input type="hidden" name="buku_ids[]" :value="id">
                </template>

                <button type="submit" class="w-full sm:w-auto bg-[#5a86e5] hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-8 py-3.5 rounded-full font-bold text-lg shadow-lg flex items-center justify-center gap-3 transition-colors">
                    Selesaikan Peminjaman <i class="ph ph-check-circle text-xl"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Modal Peringatan Batas Maksimal -->
    <div x-show="showLimitModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <!-- Backdrop Transparan -->
        <div x-show="showLimitModal" x-transition.opacity class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showLimitModal = false"></div>

        <!-- Konten Pop-up -->
        <div x-show="showLimitModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90 translate-y-8"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-90 translate-y-8"
             class="relative bg-white dark:bg-slate-800 rounded-3xl p-6 sm:p-8 w-full max-w-sm shadow-2xl text-center transform transition-colors border border-transparent dark:border-slate-700">

            <div class="w-20 h-20 bg-red-50 dark:bg-red-500/10 text-red-500 dark:text-red-400 rounded-full flex items-center justify-center mx-auto mb-5 shadow-inner border border-red-100 dark:border-red-500/20 transition-colors">
                <i class="ph ph-warning-octagon text-5xl"></i>
            </div>

            <h3 class="text-xl font-black text-gray-900 dark:text-slate-100 mb-2 tracking-tight transition-colors">Batas Maksimal!</h3>
            <p class="text-gray-500 dark:text-slate-400 text-sm mb-8 leading-relaxed transition-colors">
                Maaf, aturan perpustakaan membatasi peminjaman maksimal <strong class="text-[#5a86e5] dark:text-blue-400 text-base" x-text="maxLimit"></strong> buku dalam satu waktu.
            </p>

            <button @click="showLimitModal = false" type="button" class="w-full bg-gray-900 dark:bg-slate-900 hover:bg-black dark:hover:bg-black/80 text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 border border-transparent dark:border-slate-700">
                Saya Mengerti
            </button>
        </div>
    </div>

    <!-- Script Alpine JS -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('kioskApp', (maxBuku) => ({
                // Mode Tema
                darkMode: localStorage.getItem('kioskDarkMode') === 'true',

                // Keranjang
                selectedIds: [],
                maxLimit: maxBuku,
                showLimitModal: false,

                // Pencarian & Filter DDC
                searchQuery: '',
                searchCategory: '',

                init() {
                    // Pantau perubahan tema dan simpan ke LocalStorage
                    this.$watch('darkMode', val => localStorage.setItem('kioskDarkMode', val));
                },

                toggleTheme() {
                    this.darkMode = !this.darkMode;
                },

                toggleBook(id) {
                    const index = this.selectedIds.indexOf(id);
                    if (index > -1) {
                        this.selectedIds.splice(index, 1);
                    } else {
                        if (this.selectedIds.length >= this.maxLimit) {
                            this.showLimitModal = true;
                            return;
                        }
                        this.selectedIds.push(id);
                    }
                },

                isSelected(id) {
                    return this.selectedIds.includes(id);
                },

                // Fungsi Live Search & Filter Real-Time
                matchesSearch(judul, pengarang, kategoriId) {
                        // 1. Cek Kategori DDC terlebih dahulu
                        if (this.searchCategory !== '' && kategoriId !== this.searchCategory) {
                            return false; // Jika kategori tidak cocok, langsung sembunyikan
                        }

                        // 2. Cek Input Teks (Judul / Pengarang)
                        if (this.searchQuery === '') return true;

                        const query = this.searchQuery.toLowerCase();
                        const textToSearch = (judul + ' ' + pengarang).toLowerCase();

                        return textToSearch.includes(query);
                }
            }));
        });
        // Fungsi Pop-up Sukses Peminjaman
        function konfirmasiSelesai() {
                // Ambil status tema saat ini untuk menyesuaikan warna Pop-up
                const isDark = document.documentElement.classList.contains('dark');

                Swal.fire({
                    title: 'Peminjaman Selesai!',
                    text: "Data berhasil dicatat. Silakan bawa buku Anda.",
                    icon: 'success',
                    confirmButtonColor: '#5a86e5',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false, // Memaksa siswa untuk klik OK
                    background: isDark ? '#1e293b' : '#ffffff',
                    color: isDark ? '#f8fafc' : '#1e293b',
                    customClass: {
                        popup: 'rounded-3xl shadow-2xl border ' + (isDark ? 'border-slate-700' : 'border-transparent'),
                        confirmButton: 'px-10 py-3 rounded-full text-base font-bold shadow-md'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika OK ditekan, lanjutkan submit data ke server (Laravel)
                        document.getElementById('formSubmitPeminjaman').submit();
                    }
                });
            }
    </script>
</body>
</html>
