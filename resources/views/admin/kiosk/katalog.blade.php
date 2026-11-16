<!DOCTYPE html>
<html lang="id" x-data="kioskApp({{ $pengaturan->maksimal_buku_pinjam ?? 1 }})" :class="{ 'dark': darkMode }" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku SD Kiosk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-[#f8fafd] dark:bg-slate-950 min-h-screen pb-32 font-sans transition-colors duration-300 ease-in-out">

    <!-- HEADER -->
    <header class="bg-[#5a86e5] dark:bg-slate-900 sticky top-0 z-40 shadow-sm transition-colors border-b border-transparent dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-3 text-white">
                <button class="p-1 hover:bg-white/20 rounded transition-colors focus:outline-none hidden sm:block"><i class="ph ph-list text-2xl"></i></button>
                <h1 class="font-bold text-sm sm:text-base tracking-wide flex items-center gap-2"><i class="ph ph-books sm:hidden text-xl"></i> Perpustakaan Digital</h1>
            </div>

            <div class="flex items-center gap-4 sm:gap-6">
                <button @click="toggleTheme()" class="text-white/80 hover:text-white transition-colors focus:outline-none flex items-center justify-center transform hover:scale-110" title="Ganti Mode Tema">
                    <i class="ph text-xl transition-all" :class="darkMode ? 'ph-sun-dim text-amber-400' : 'ph-moon-stars'"></i>
                </button>
                <div class="flex items-center gap-3 border-l border-white/20 pl-4 sm:pl-6">
                    <a href="{{ route('kiosk.index') }}" class="flex items-center gap-1.5 text-white/90 hover:text-white text-xs sm:text-sm font-semibold transition-colors">
                        <i class="ph ph-sign-out text-lg"></i><span class="hidden sm:inline">LOGOUT</span>
                    </a>
                    <div class="flex items-center gap-2 bg-white/15 py-1.5 px-3 rounded-full border border-white/25 cursor-default">
                        <i class="ph-fill ph-user-circle text-xl text-white"></i>
                        <span class="text-xs sm:text-sm font-semibold text-white max-w-[100px] sm:max-w-[150px] truncate">{{ session('kiosk_anggota_nama') ?? 'Siswa' }}</span>
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
                '600' => 'Teknologi Terapan', '700' => 'Seni & Olahraga', '800' => 'Kesusastraan', '900' => 'Sejarah & Geografi',
            ];
        @endphp

        <!-- HERO SECTION -->
        <div class="text-center max-w-4xl mx-auto mb-12">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-800 dark:text-slate-100 mb-3 tracking-tight transition-colors">Selamat Datang Anak-Anak</h2>
            <p class="text-gray-500 dark:text-slate-400 text-sm sm:text-base transition-colors">Temukan buku yang ingin kamu pinjam disini.</p>

            <div class="mt-8 flex flex-col md:flex-row items-center justify-center gap-3">
                <!-- KOTAK PENCARIAN -->
                <div class="relative w-full md:w-[450px]">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i class="ph ph-magnifying-glass text-gray-400 text-lg"></i></div>
                    <input type="text" x-model="searchQuery" placeholder="Cari judul buku atau pengarang..." class="w-full pl-11 pr-10 py-3.5 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-full shadow-sm focus:ring-2 focus:ring-[#5a86e5] outline-none text-sm font-medium text-gray-700 dark:text-slate-200 placeholder-gray-400 transition-colors">
                    <button x-show="searchQuery.length > 0" @click="searchQuery = ''" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-slate-300"><i class="ph ph-x-circle text-lg"></i></button>
                </div>

                <!-- TOMBOL FILTER KATEGORI STATIS (52x52) -->
                <div class="relative" x-data="{ openFilter: false }">
                    <button @click="openFilter = !openFilter" @click.away="openFilter = false" type="button"
                        class="w-[52px] h-[52px] bg-white dark:bg-slate-900 border rounded-full flex items-center justify-center shadow-sm transition-all duration-300 focus:outline-none cursor-pointer relative"
                        :class="searchCategory !== '' ? 'border-[#5a86e5] dark:border-blue-500 ring-2 ring-[#5a86e5]/20' : 'border-gray-200 dark:border-slate-700 hover:border-[#5a86e5] dark:hover:border-blue-400'"
                        :title="getCategoryShortName()">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300" :class="getCategoryBadgeClass()">
                            <i class="text-xl transition-transform duration-300" :class="getCategoryIcon()"></i>
                        </div>
                        <span x-show="searchCategory !== ''" x-transition class="absolute -top-1 -right-1 px-1.5 py-0.5 rounded-full bg-[#5a86e5] text-white text-[9px] font-extrabold leading-none shadow border border-white dark:border-slate-900" x-text="searchCategory"></span>
                    </button>

                    <!-- DROPDOWN KATEGORI -->
                    <div x-show="openFilter" x-transition style="display: none;" class="absolute right-0 md:left-1/2 md:-translate-x-1/2 top-[58px] w-72 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-100 dark:border-slate-700 z-50 py-2 overflow-hidden text-left h-fit max-h-[60vh] overflow-y-auto [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                        <div class="px-4 py-2 border-b border-gray-100 dark:border-slate-700/50 flex items-center justify-between">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Pilih Kategori DDC</p>
                            <span x-show="searchCategory !== ''" @click="searchCategory = ''; openFilter = false" class="text-[10px] font-bold text-red-500 hover:underline cursor-pointer">Reset</span>
                        </div>
                        <button @click="searchCategory = ''; openFilter = false" class="w-full px-4 py-2.5 text-left text-sm font-medium transition-colors hover:bg-gray-50 dark:hover:bg-slate-700/60 flex items-center justify-between" :class="searchCategory === '' ? 'text-[#5a86e5] font-bold bg-blue-50/70 dark:bg-slate-700/50' : 'text-gray-700 dark:text-slate-200'">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-slate-700 text-[#5a86e5] dark:text-blue-400 flex items-center justify-center shrink-0"><i class="ph-fill ph-squares-four text-base"></i></div>
                                <span>Semua Kategori</span>
                            </div>
                            <i x-show="searchCategory === ''" class="ph-fill ph-check-circle text-lg text-[#5a86e5] dark:text-blue-400"></i>
                        </button>
                        @foreach($kategoriLabel as $key => $label)
                            <button @click="searchCategory = '{{ $key }}'; openFilter = false" class="w-full px-4 py-2.5 text-left text-sm font-medium transition-colors hover:bg-gray-50 dark:hover:bg-slate-700/60 flex items-center justify-between group" :class="searchCategory === '{{ $key }}' ? 'text-[#5a86e5] font-bold bg-blue-50/70 dark:bg-slate-700/50' : 'text-gray-700 dark:text-slate-200'">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 transition-transform group-hover:scale-110" :class="getCategoryBadgeClass('{{ $key }}')">
                                        <i class="text-base" :class="getCategoryIcon('{{ $key }}')"></i>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-bold leading-tight">{{ $label }}</span>
                                        <span class="block text-[10px] text-gray-400 dark:text-slate-400 font-mono">Kode DDC: {{ $key }}</span>
                                    </div>
                                </div>
                                <i x-show="searchCategory === '{{ $key }}'" class="ph-fill ph-check-circle text-lg text-[#5a86e5] dark:text-blue-400"></i>
                            </button>
                        @endforeach
                    </div>
                </div>

                <button class="w-full md:w-auto bg-[#5a86e5] hover:bg-blue-600 text-white px-8 h-[52px] rounded-full font-bold shadow-sm transition-colors flex items-center justify-center gap-2 cursor-pointer">
                    <i class="ph-bold ph-magnifying-glass text-base"></i><span>Cari</span>
                </button>
            </div>
        </div>

        <!-- GRID KATALOG BUKU -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4 lg:gap-5">
            @if(isset($bukus))
                @foreach($bukus as $kategori => $kumpulanBuku)
                    @foreach($kumpulanBuku as $buku)
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col h-full relative group transition-all duration-300 hover:shadow-md"
                             x-show="matchesSearch(`{{ addslashes($buku->judul) }}`, `{{ addslashes($buku->pengarang) }}`, `{{ $kategori }}`)">
                            <div class="p-2.5 sm:p-3 pb-0 relative">
                                <div class="relative w-full aspect-[4/5] bg-gray-100 dark:bg-slate-900 rounded-xl cursor-pointer overflow-hidden border border-gray-50 dark:border-slate-700" @click="toggleBook({{ $buku->id }})">
                                    @if($buku->gambar_sampul)
                                        <img src="{{ asset('storage/' . $buku->gambar_sampul) }}" onerror="this.onerror=null;this.src='https://placehold.co/300x400/f3f4f6/a1a1aa?text=Buku'" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" :class="isSelected({{ $buku->id }}) ? 'scale-105 opacity-80' : ''">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 dark:text-slate-600 transition-transform duration-500 group-hover:scale-105"><i class="ph ph-book-open text-3xl mb-1"></i></div>
                                    @endif
                                    <div x-show="isSelected({{ $buku->id }})" x-transition style="display: none;" class="absolute inset-0 bg-[#5a86e5]/20 dark:bg-blue-500/30 flex items-start justify-end p-2 z-10">
                                        <div class="bg-[#5a86e5] text-white rounded-full p-1 shadow-lg transform scale-110"><i class="ph ph-check-circle-fill text-lg"></i></div>
                                    </div>
                                    <div class="absolute bottom-2 left-0 right-0 flex justify-center z-20">
                                        <span class="bg-gray-800/90 backdrop-blur-sm text-white text-[9px] px-2.5 py-1 rounded-full font-bold tracking-widest uppercase shadow-md border border-gray-600/50">Sisa: {{ $buku->stok }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col flex-1 px-3 py-3">
                                <p class="text-[9px] font-bold text-[#5a86e5] dark:text-blue-400 uppercase tracking-widest mb-1 line-clamp-1 transition-colors">{{ $kategoriLabel[$kategori] ?? $kategori }}</p>
                                <h4 class="font-extrabold text-gray-900 dark:text-slate-100 text-[12px] sm:text-[13px] leading-snug line-clamp-2 mb-0.5 min-h-[2.1rem] transition-colors" title="{{ $buku->judul }}">{{ $buku->judul }}</h4>
                                <p class="text-[10px] sm:text-[11px] text-gray-400 dark:text-slate-500 line-clamp-1 mb-2.5 transition-colors" title="{{ $buku->pengarang }}">{{ $buku->pengarang }}</p>
                                <div class="mt-auto">
                                    <button @click="toggleBook({{ $buku->id }})" class="w-full py-1.5 sm:py-2 rounded-xl text-xs font-bold transition-all duration-300 border flex items-center justify-center gap-1.5 cursor-pointer"
                                            :class="isSelected({{ $buku->id }}) ? 'bg-red-50 text-red-500 border-red-200 hover:bg-red-500 hover:text-white dark:bg-red-500/10 dark:border-red-500/30' : 'bg-white text-[#5a86e5] border-gray-200 hover:border-[#5a86e5] dark:bg-slate-800 dark:border-slate-600 dark:hover:border-blue-500'">
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

        <div x-show="searchQuery.length > 0 || searchCategory !== ''" style="display: none;" class="mt-12 text-center text-gray-500 dark:text-slate-400 transition-colors">
            <p class="text-sm font-medium">Menampilkan hasil <span x-show="searchQuery.length > 0">untuk "<span class="font-bold text-[#5a86e5] dark:text-blue-400" x-text="searchQuery"></span>"</span> <span x-show="searchCategory !== ''">di kategori <span class="font-bold text-[#5a86e5] dark:text-blue-400" x-text="getCategoryShortName()"></span></span></p>
        </div>
    </main>

    <!-- FLOATING ACTION BAR -->
    <div class="fixed bottom-0 inset-x-0 bg-white dark:bg-slate-900 border-t border-gray-200 dark:border-slate-800 shadow-[0_-10px_40px_rgba(0,0,0,0.08)] dark:shadow-[0_-10px_40px_rgba(0,0,0,0.5)] z-50 transform transition-all duration-300" :class="selectedIds.length > 0 ? 'translate-y-0' : 'translate-y-full'">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-slate-400 font-medium mb-0.5 transition-colors">Buku Terpilih</p>
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-extrabold text-[#5a86e5] dark:text-blue-400 transition-colors" x-text="selectedIds.length"></span>
                    <span class="text-gray-400 dark:text-slate-500 font-medium transition-colors">/ {{ $pengaturan->maksimal_buku_pinjam ?? 1 }} Maksimal</span>
                </div>
            </div>
            <form action="{{ route('kiosk.store') }}" method="POST" id="formSubmitPeminjaman" class="w-full sm:w-auto m-0" onsubmit="event.preventDefault(); konfirmasiSelesai()">
                @csrf
                <template x-for="id in selectedIds"><input type="hidden" name="buku_ids[]" :value="id"></template>
                <button type="submit" class="w-full sm:w-auto bg-[#5a86e5] hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-8 py-3.5 rounded-full font-bold text-lg shadow-lg flex items-center justify-center gap-3 transition-colors cursor-pointer">
                    Selesaikan Peminjaman <i class="ph ph-check-circle text-xl"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- MODAL PERINGATAN BATAS MAKSIMAL -->
    <div x-show="showLimitModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div x-show="showLimitModal" x-transition.opacity class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showLimitModal = false"></div>
        <div x-show="showLimitModal" x-transition class="relative bg-white dark:bg-slate-800 rounded-3xl p-6 sm:p-8 w-full max-w-sm shadow-2xl text-center transform transition-colors border border-transparent dark:border-slate-700">
            <div class="w-20 h-20 bg-red-50 dark:bg-red-500/10 text-red-500 dark:text-red-400 rounded-full flex items-center justify-center mx-auto mb-5 shadow-inner border border-red-100 dark:border-red-500/20"><i class="ph ph-warning-octagon text-5xl"></i></div>
            <h3 class="text-xl font-black text-gray-900 dark:text-slate-100 mb-2 tracking-tight">Batas Maksimal!</h3>
            <p class="text-gray-500 dark:text-slate-400 text-sm mb-8 leading-relaxed">Maaf, aturan perpustakaan membatasi peminjaman maksimal <strong class="text-[#5a86e5] dark:text-blue-400 text-base" x-text="maxLimit"></strong> buku.</p>
            <button @click="showLimitModal = false" type="button" class="w-full bg-gray-900 dark:bg-slate-900 hover:bg-black text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-lg border border-transparent dark:border-slate-700 cursor-pointer">Saya Mengerti</button>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('kioskApp', (maxBuku) => ({
                darkMode: localStorage.getItem('kioskDarkMode') === 'true',
                selectedIds: [], maxLimit: maxBuku, showLimitModal: false, searchQuery: '', searchCategory: '',
                categoryMeta: {
                    '000': { icon: 'ph-fill ph-desktop', badge: 'bg-indigo-100 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-400', label: '000 - Komputer' },
                    '100': { icon: 'ph-fill ph-brain', badge: 'bg-purple-100 text-purple-600 dark:bg-purple-500/20 dark:text-purple-400', label: '100 - Filsafat' },
                    '200': { icon: 'ph-fill ph-mosque', badge: 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400', label: '200 - Agama' },
                    '300': { icon: 'ph-fill ph-users-three', badge: 'bg-amber-100 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400', label: '300 - Sosial' },
                    '400': { icon: 'ph-fill ph-translate', badge: 'bg-pink-100 text-pink-600 dark:bg-pink-500/20 dark:text-pink-400', label: '400 - Bahasa' },
                    '500': { icon: 'ph-fill ph-atom', badge: 'bg-cyan-100 text-cyan-600 dark:bg-cyan-500/20 dark:text-cyan-400', label: '500 - Sains' },
                    '600': { icon: 'ph-fill ph-cpu', badge: 'bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400', label: '600 - Teknologi' },
                    '700': { icon: 'ph-fill ph-palette', badge: 'bg-rose-100 text-rose-600 dark:bg-rose-500/20 dark:text-rose-400', label: '700 - Seni & Olahraga' },
                    '800': { icon: 'ph-fill ph-book-open-text', badge: 'bg-violet-100 text-violet-600 dark:bg-violet-500/20 dark:text-violet-400', label: '800 - Sastra' },
                    '900': { icon: 'ph-fill ph-globe-hemisphere-east', badge: 'bg-teal-100 text-teal-600 dark:bg-teal-500/20 dark:text-teal-400', label: '900 - Sejarah' },
                },
                init() { this.$watch('darkMode', val => localStorage.setItem('kioskDarkMode', val)); },
                toggleTheme() { this.darkMode = !this.darkMode; },
                getCategoryIcon(code = null) {
                    const key = code !== null ? code : this.searchCategory;
                    return (key && this.categoryMeta[key]) ? this.categoryMeta[key].icon : 'ph-bold ph-funnel';
                },
                getCategoryBadgeClass(code = null) {
                    const key = code !== null ? code : this.searchCategory;
                    return (key && this.categoryMeta[key]) ? this.categoryMeta[key].badge : 'bg-gray-100 text-gray-500 dark:bg-slate-800 dark:text-slate-400';
                },
                getCategoryShortName() {
                    return (this.searchCategory && this.categoryMeta[this.searchCategory]) ? this.categoryMeta[this.searchCategory].label : 'Semua Kategori';
                },
                toggleBook(id) {
                    const idx = this.selectedIds.indexOf(id);
                    if (idx > -1) this.selectedIds.splice(idx, 1);
                    else if (this.selectedIds.length >= this.maxLimit) this.showLimitModal = true;
                    else this.selectedIds.push(id);
                },
                isSelected(id) { return this.selectedIds.includes(id); },
                matchesSearch(judul, pengarang, kategoriId) {
                    if (this.searchCategory !== '' && kategoriId !== this.searchCategory) return false;
                    return this.searchQuery === '' || (judul + ' ' + pengarang).toLowerCase().includes(this.searchQuery.toLowerCase());
                }
            }));
        });

        function getSwalTheme() {
            const isDark = document.documentElement.classList.contains('dark');
            return {
                background: isDark ? '#1e293b' : '#ffffff', color: isDark ? '#f8fafc' : '#1e293b',
                customClass: {
                    popup: 'rounded-3xl shadow-2xl border ' + (isDark ? 'border-slate-700' : 'border-transparent'),
                    confirmButton: 'px-8 py-2.5 rounded-full text-sm font-bold shadow-md',
                    cancelButton: 'px-8 py-2.5 rounded-full text-sm font-bold shadow-md'
                }
            };
        }

        function konfirmasiSelesai() {
            const theme = getSwalTheme();
            Swal.fire({
                ...theme, title: 'Konfirmasi Peminjaman', text: "Apakah kamu yakin ingin meminjam buku-buku yang dipilih?",
                icon: 'question', showCancelButton: true, confirmButtonColor: '#5a86e5', cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Pinjam', cancelButtonText: 'Batal', allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({ ...theme, title: 'Memproses Data...', text: 'Mohon tunggu sebentar', allowOutsideClick: false, showConfirmButton: false, didOpen: () => Swal.showLoading() });
                    document.getElementById('formSubmitPeminjaman').submit();
                }
            });
        }

        @if(session('success'))
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({ ...getSwalTheme(), title: 'Peminjaman Selesai!', text: "{{ session('success') }}", icon: 'success', confirmButtonColor: '#5a86e5' });
        });
        @endif
    </script>
</body>
</html>
