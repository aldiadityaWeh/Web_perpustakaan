<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Alpine.js untuk fitur Keranjang Belanja -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Sembunyikan scrollbar tapi tetap bisa scroll */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        /* Mencegah kedipan UI sebelum Alpine dimuat */
        [x-cloak] { display: none !important; }
        /* Efek meluncur mulus saat menu kategori ditekan */
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen pb-32 font-sans"
      x-data="keranjangBuku({{ $pengaturan->maksimal_buku_pinjam }})">

    <!-- Header / Navbar -->
    <header class="bg-purple-600 sticky top-0 z-40 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 text-white border border-white/30 rounded-full flex items-center justify-center shadow-inner">
                    <i class="ph ph-user-circle text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs text-purple-200 font-medium">Peminjam:</p>
                    <h2 class="text-sm sm:text-base font-bold text-white">{{ session('kiosk_anggota_nama') }}</h2>
                </div>
            </div>
            <a href="{{ route('kiosk.index') }}" class="text-sm font-bold text-white hover:text-red-50 bg-red-500 hover:bg-red-600 border border-red-600 px-4 py-2 rounded-xl transition-all shadow-sm">
                Batal
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @php
            $kategoriLabel = [
                '000' => 'Komputer & Informasi', '100' => 'Filsafat & Psikologi', '200' => 'Agama',
                '300' => 'Ilmu Sosial', '400' => 'Bahasa', '500' => 'Sains & Matematika',
                '600' => 'Teknologi Terapan', '700' => 'Seni & Olahraga', '800' => 'Kesusastraan',
                '900' => 'Sejarah & Geografi',
            ];
        @endphp

        <!-- Header Katalog & Menu Kategori (Digabung Sejajar & Sticky) -->
        <div class="sticky top-[73px] z-30 bg-gray-50/95 backdrop-blur-md pt-2 pb-4 -mx-4 px-4 sm:mx-0 sm:px-0 mb-8 border-b border-gray-200/60 flex flex-col sm:flex-row sm:items-center justify-between gap-4" x-data="{ openDropdown: false }">

            <!-- Kiri: Judul dan Info -->
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Katalog Buku</h1>
                <p class="text-gray-500 mt-1">Pilih maksimal <span class="font-bold text-purple-600">{{ $pengaturan->maksimal_buku_pinjam }} buku</span> yang ingin Anda pinjam hari ini.</p>
            </div>

            <!-- Kanan: Tombol Dropdown Berwarna -->
            <div class="relative shrink-0">
                <!-- Tombol Hamburger -->
                <button @click="openDropdown = !openDropdown" @click.away="openDropdown = false"
                        class="flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white border border-purple-700 px-5 py-2.5 rounded-xl text-sm font-bold shadow-md hover:shadow-lg transition-all focus:outline-none">
                    <i class="ph ph-list text-xl"></i>
                    <span>Pilih Kategori</span>
                    <i class="ph ph-caret-down text-xs transition-transform duration-200" :class="openDropdown ? 'rotate-180' : ''"></i>
                </button>

                <!-- Isi Dropdown Kategori -->
                <div x-show="openDropdown"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-[-10px]"
                     x-cloak
                     class="absolute right-0 mt-2 w-64 bg-white border border-gray-100 rounded-2xl shadow-xl py-2 z-50 overflow-hidden">

                    <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/50">
                        <p class="text-[10px] font-extrabold text-gray-500 uppercase tracking-widest">Daftar Kategori</p>
                    </div>

                    <div class="max-h-[60vh] overflow-y-auto no-scrollbar py-1">
                        @foreach($bukus as $kategori => $kumpulanBuku)
                            <a href="#kategori-{{ $kategori }}"
                               @click="openDropdown = false"
                               class="group flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-purple-50 hover:text-purple-700 font-bold transition-colors">
                                <div class="w-1.5 h-1.5 rounded-full bg-gray-300 group-hover:bg-purple-500 transition-colors"></div>
                                {{ $kategoriLabel[$kategori] ?? ucfirst($kategori) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Buku Berdasarkan Kategori -->
        <div class="space-y-12">
            @foreach($bukus as $kategori => $kumpulanBuku)
                <!-- Tambahkan ID dan scroll-mt (scroll margin top) agar saat melompat tidak tertutup header -->
                <section id="kategori-{{ $kategori }}" class="scroll-mt-40">
                    <div class="flex items-center gap-3 mb-5">
                        <h3 class="text-xl font-bold text-gray-800 border-l-4 border-purple-500 pl-3 leading-none">
                            {{ $kategoriLabel[$kategori] ?? ucfirst($kategori) }}
                        </h3>

                        <!-- Badge Jumlah Buku dengan Icon Kustom -->
                        <div class="flex items-center gap-2 bg-white border border-gray-200 shadow-sm pl-1 pr-3 py-1 rounded-full">
                            <img src="{{ asset('images/peminjaman.png') }}" alt="Icon" class="w-8 h-8 object-cover rounded-full bg-gray-50 border border-gray-100 shadow-sm">
                            <span class="text-gray-800 text-sm font-black">{{ count($kumpulanBuku) }}</span>
                        </div>
                    </div>

                    <!-- Grid Buku -->
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6">
                        @foreach($kumpulanBuku as $buku)
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow relative flex flex-col h-full"
                                 :class="{'ring-2 ring-purple-500 border-purple-500': isSelected({{ $buku->id }})}">

                                <!-- Tanda Checkmark jika dipilih -->
                                <div x-show="isSelected({{ $buku->id }})" x-transition class="absolute top-2 right-2 bg-purple-500 text-white w-6 h-6 rounded-full flex items-center justify-center z-10 shadow-sm">
                                    <i class="ph ph-check font-bold text-sm"></i>
                                </div>

                                <div class="h-48 sm:h-56 bg-gray-100 relative w-full">
                                    @if($buku->gambar_sampul)
                                        <img src="{{ asset('storage/' . $buku->gambar_sampul) }}" onerror="this.onerror=null;this.src='https://placehold.co/200x300/f3f4f6/a1a1aa?text=Buku'" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                            <i class="ph ph-book-open text-4xl mb-2"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-4 flex flex-col flex-grow">
                                    <h4 class="font-bold text-gray-900 text-sm leading-snug line-clamp-2 mb-1">{{ $buku->judul }}</h4>
                                    <p class="text-xs text-gray-500 mb-3">{{ $buku->pengarang }}</p>

                                    <!-- BAGIAN BARU: LABEL SISA STOK (Warna Diselaraskan) -->
                                    <div class="flex items-center mb-4">
                                        <span class="inline-flex items-center gap-1.5 bg-purple-50 text-purple-700 border border-purple-200 px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider shadow-sm">
                                            <i class="ph ph-stack text-sm"></i> Sisa: {{ $buku->stok }} Buku
                                        </span>
                                    </div>
                                    <!-- AKHIR BAGIAN BARU -->

                                    <div class="mt-auto">
                                        <!-- Tombol Pilih AlpineJS (Desain Baru dengan Border & Warna) -->
                                        <button @click="toggleBook({{ $buku->id }})"
                                                class="w-full py-2.5 px-3 rounded-xl text-sm font-bold transition-all duration-300 border-2"
                                                :class="isSelected({{ $buku->id }})
                                                    ? 'bg-red-50 text-red-500 border-red-200 hover:bg-red-500 hover:text-white hover:border-red-500 hover:shadow-md'
                                                    : 'bg-white text-purple-600 border-purple-300 shadow-sm hover:bg-purple-600 hover:text-white hover:border-purple-600 hover:shadow-md'">
                                            <div class="flex items-center justify-center gap-2">
                                                <i class="text-lg" :class="isSelected({{ $buku->id }}) ? 'ph ph-x-circle' : 'ph ph-plus-circle'"></i>
                                                <span x-text="isSelected({{ $buku->id }}) ? 'Batal Pilih' : 'Pilih Buku'"></span>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>

    </main>

    <!-- Floating Action Bar (Cart) di bawah -->
    <div class="fixed bottom-0 inset-x-0 bg-white border-t border-gray-200 shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-50 transform transition-transform duration-300"
         :class="selectedIds.length > 0 ? 'translate-y-0' : 'translate-y-full'">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-0.5">Buku Terpilih</p>
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-extrabold text-purple-600" x-text="selectedIds.length"></span>
                    <span class="text-gray-400 font-medium">/ {{ $pengaturan->maksimal_buku_pinjam }} Maksimal</span>
                </div>
            </div>

            <!-- Form Tersembunyi untuk Submit -->
            <form action="{{ route('kiosk.store') }}" method="POST" id="formSubmitPeminjaman" class="w-full sm:w-auto">
                @csrf
                <template x-for="id in selectedIds">
                    <input type="hidden" name="buku_ids[]" :value="id">
                </template>

                <button type="submit" class="w-full sm:w-auto bg-purple-600 hover:bg-purple-700 text-white px-8 py-3.5 rounded-2xl font-bold text-lg shadow-lg flex items-center justify-center gap-3 transition-colors">
                    Pinjam <i class="ph ph-check-circle text-xl"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Modal Peringatan Batas Maksimal (Pop-up Kustom) -->
    <div x-show="showLimitModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <!-- Backdrop Transparan -->
        <div x-show="showLimitModal" x-transition.opacity class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showLimitModal = false"></div>

        <!-- Konten Pop-up -->
        <div x-show="showLimitModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90 translate-y-8"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-90 translate-y-8"
             class="relative bg-white rounded-3xl p-6 sm:p-8 w-full max-w-sm shadow-2xl text-center transform transition-all">

            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-5 shadow-inner border border-red-100">
                <i class="ph ph-warning-octagon text-5xl"></i>
            </div>

            <h3 class="text-xl font-black text-gray-900 mb-2 tracking-tight">Batas Maksimal!</h3>
            <p class="text-gray-500 text-sm mb-8 leading-relaxed">
                Maaf, aturan perpustakaan membatasi peminjaman maksimal <strong class="text-purple-600 text-base" x-text="maxLimit"></strong> buku dalam satu waktu.
            </p>

            <button @click="showLimitModal = false" type="button" class="w-full bg-gray-900 hover:bg-black text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                Saya Mengerti
            </button>
        </div>
    </div>

    <!-- Script Alpine JS untuk Logika Keranjang -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('keranjangBuku', (maxBuku) => ({
                selectedIds: [],
                maxLimit: maxBuku,
                showLimitModal: false, // Variabel state untuk pop-up

                toggleBook(id) {
                    const index = this.selectedIds.indexOf(id);
                    if (index > -1) {
                        // Jika sudah ada, hapus (Batal pilih)
                        this.selectedIds.splice(index, 1);
                    } else {
                        // Jika belum ada, tambah (Cek limit dulu)
                        if (this.selectedIds.length >= this.maxLimit) {
                            // Tampilkan Pop-up Kustom (Bukan alert lagi)
                            this.showLimitModal = true;
                            return;
                        }
                        this.selectedIds.push(id);
                    }
                },

                isSelected(id) {
                    return this.selectedIds.includes(id);
                }
            }));
        });
    </script>
</body>
</html>
