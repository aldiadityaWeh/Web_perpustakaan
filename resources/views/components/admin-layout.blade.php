<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistem Perpustakaan' }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class', // Wajib agar dark mode bisa di-toggle manual
        }
    </script>

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Alpine.js untuk interaksi Toggle Sidebar, Mobile Drawer & Dark Mode -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        /* Transisi warna dasar agar perpindahan terang-gelap terasa mulus */
        body { transition: background-color 0.3s ease, color 0.3s ease; }
    </style>
</head>

<body class="bg-gray-50 dark:bg-slate-900 text-gray-800 dark:text-slate-200 font-sans antialiased overflow-hidden">

    <!-- Alpine x-data -->
    <div x-data="{ desktopOpen: true, mobileOpen: false }" class="flex h-screen w-full relative">

        <!-- BACKDROP OVERLAY UNTUK MOBILE -->
        <div
            x-show="mobileOpen"
            x-cloak
            @click="mobileOpen = false"
            x-transition.opacity
            class="fixed inset-0 bg-black/60 z-30 lg:hidden backdrop-blur-sm"
        ></div>

        <!-- SIDEBAR -->
        <aside
            class="bg-white dark:bg-slate-800 border-r border-gray-200 dark:border-slate-700 flex flex-col transition-all duration-300 ease-in-out shrink-0 shadow-sm z-40 fixed lg:static inset-y-0 left-0"
            :class="{
                'w-64': desktopOpen,
                'w-20': !desktopOpen,
                '-translate-x-full lg:translate-x-0': !mobileOpen,
                'translate-x-0 w-64': mobileOpen
            }"
        >
            <!-- Sidebar Header -->
            <div class="p-4 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between gap-3 h-16">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="h-10 w-10 rounded-full bg-white dark:bg-slate-700 flex items-center justify-center shrink-0 overflow-hidden shadow-sm border border-gray-100 dark:border-slate-600">
                        <img src="{{ asset('images/sd.png') }}" alt="Logo Sekolah" class="w-full h-full object-contain p-0.5">
                    </div>

                    <div x-show="desktopOpen || mobileOpen" x-transition.opacity class="overflow-hidden whitespace-nowrap">
                        <p class="font-bold text-sm text-gray-800 dark:text-slate-100 leading-none">Perpustakaan</p>
                        <p class="text-xs text-gray-400 dark:text-slate-400 mt-1">SDN 6 Ciseureuh</p>
                    </div>
                </div>
                <button @click="mobileOpen = false" class="lg:hidden text-gray-400 hover:text-gray-600 dark:hover:text-white">
                    <i class="ph ph-x text-xl"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto py-4 px-3 flex flex-col gap-1 no-scrollbar">

                <!-- Dashboard -->
                <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('dashboard.*') ? 'bg-purple-100 dark:bg-purple-500/20 text-purple-700 dark:text-purple-400 font-semibold' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-gray-900 dark:hover:text-slate-200' }}">
                    <i class="ph ph-squares-four text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Dashboard</span>
                </a>

                <!-- Manajemen Data -->
                <div x-show="desktopOpen || mobileOpen" class="text-[11px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mt-4 mb-1 px-3">Manajemen Data</div>

                <a href="{{ route('buku.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('buku.*') ? 'bg-purple-100 dark:bg-purple-500/20 text-purple-700 dark:text-purple-400 font-semibold' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-gray-900 dark:hover:text-slate-200' }}">
                    <i class="ph ph-book text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Data Buku</span>
                </a>
                <a href="{{ route('anggota.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('anggota.*') ? 'bg-purple-100 dark:bg-purple-500/20 text-purple-700 dark:text-purple-400 font-semibold' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-gray-900 dark:hover:text-slate-200' }}">
                    <i class="ph ph-users text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Data Anggota</span>
                </a>

                <!-- Sirkulasi & Kas -->
                <div x-show="desktopOpen || mobileOpen" class="text-[11px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mt-4 mb-1 px-3">Sirkulasi & Kas</div>

                <a href="{{ route('peminjaman.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('peminjaman.*') ? 'bg-purple-100 dark:bg-purple-500/20 text-purple-700 dark:text-purple-400 font-semibold' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-gray-900 dark:hover:text-slate-200' }}">
                    <i class="ph ph-handshake text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Peminjaman</span>
                </a>
                <a href="{{ route('pengembalian.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('pengembalian.*') ? 'bg-purple-100 dark:bg-purple-500/20 text-purple-700 dark:text-purple-400 font-semibold' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-gray-900 dark:hover:text-slate-200' }}">
                    <i class="ph ph-clock-counter-clockwise text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Pengembalian</span>
                </a>
                <a href="{{ route('transaksi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('transaksi.*') ? 'bg-purple-100 dark:bg-purple-500/20 text-purple-700 dark:text-purple-400 font-semibold' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-gray-900 dark:hover:text-slate-200' }}">
                    <i class="ph ph-wallet text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Kas Denda</span>
                </a>

                <!-- Laporan & Analisis -->
                <div x-show="desktopOpen || mobileOpen" class="text-[11px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mt-4 mb-1 px-3">Laporan & Analisis</div>

                <a href="{{ route('analisis.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('analisis.*') ? 'bg-purple-100 dark:bg-purple-500/20 text-purple-700 dark:text-purple-400 font-semibold' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-gray-900 dark:hover:text-slate-200' }}">
                    <i class="ph ph-chart-pie-slice text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Analisis Perpustakaan</span>
                </a>
                <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('laporan.*') ? 'bg-purple-100 dark:bg-purple-500/20 text-purple-700 dark:text-purple-400 font-semibold' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-gray-900 dark:hover:text-slate-200' }}">
                    <i class="ph ph-printer text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Laporan Cetak</span>
                </a>

                <!-- Manajemen Sistem -->
                <div x-show="desktopOpen || mobileOpen" class="text-[11px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mt-4 mb-1 px-3">Manajemen Sistem</div>

                <a href="{{ route('pengaturan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('pengaturan.*') ? 'bg-purple-100 dark:bg-purple-500/20 text-purple-700 dark:text-purple-400 font-semibold' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-gray-900 dark:hover:text-slate-200' }}">
                    <i class="ph ph-gear text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Pengaturan</span>
                </a>
                <a href="{{ route('profil.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('profil.*') ? 'bg-purple-100 dark:bg-purple-500/20 text-purple-700 dark:text-purple-400 font-semibold' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-700/50 hover:text-gray-900 dark:hover:text-slate-200' }}">
                    <i class="ph ph-user-circle text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Profil Saya</span>
                </a>
            </nav>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col overflow-hidden w-full relative">

            <!-- Topbar (Warna Ungu di Terang, Slate di Gelap) -->
            <header class="h-16 bg-[#7c3aed] dark:bg-slate-950 text-white flex items-center justify-between px-4 sm:px-6 shadow-md z-10 shrink-0 border-b border-transparent dark:border-slate-800 transition-colors duration-300">
                <div class="flex items-center gap-3 sm:gap-4">
                    <button
                        @click="if (window.innerWidth >= 1024) { desktopOpen = !desktopOpen; } else { mobileOpen = !mobileOpen; }"
                        class="text-white hover:bg-white/20 dark:hover:bg-slate-800 p-2 rounded-lg transition-colors focus:outline-none"
                    >
                        <i class="ph ph-list text-2xl"></i>
                    </button>
                    <span class="font-bold text-base sm:text-lg tracking-wide flex items-center gap-2 truncate">
                        Sistem Perpustakaan
                    </span>
                </div>

                <!-- Right Header -->
                <div class="flex items-center gap-4 sm:gap-6">

                    <!-- TOMBOL DARK MODE -->
                    <button @click="darkMode = !darkMode" class="text-white/80 hover:text-white p-2 rounded-lg hover:bg-white/10 dark:hover:bg-slate-800 transition-colors focus:outline-none flex items-center justify-center transform hover:scale-110" title="Ganti Mode Tema">
                        <!-- Animasi dan pergantian ikon Matahari / Bulan -->
                        <i class="ph text-2xl transition-all" :class="darkMode ? 'ph-sun-dim text-amber-400' : 'ph-moon-stars'"></i>
                    </button>

                    <!-- Tombol Keluar -->
                    <form method="POST" action="{{ route('logout') }}" id="form-logout" class="inline-block m-0 p-0">
                        @csrf
                        <button type="button" onclick="konfirmasiKeluar()" class="bg-red-800 hover:bg-red-900 dark:bg-red-600/20 dark:hover:bg-red-600/40 dark:text-red-400 dark:border dark:border-red-500/50 text-white font-bold py-2 px-5 rounded-lg transition-colors shadow-sm flex items-center gap-2 cursor-pointer text-sm">
                            Keluar
                        </button>
                    </form>

                </div>
            </header>

            <!-- Page Content (Slot) -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50/50 dark:bg-slate-900/50 p-4 sm:p-6 transition-colors duration-300">
                {{ $slot }}
            </main>
        </div>

    </div>

    <!-- SCRIPT SWEETALERT UNTUK LOGOUT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function konfirmasiKeluar() {
            // Cek apakah class 'dark' sedang aktif di halaman html
            const isDark = document.documentElement.classList.contains('dark');

            Swal.fire({
                title: 'Keluar Aplikasi?',
                text: "Anda akan mengakhiri sesi dan harus login kembali nanti.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                // Warna tombol batal menyesuaikan mode
                cancelButtonColor: isDark ? '#334155' : '#6b7280',
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                // Warna Background Modal menyesuaikan mode
                background: isDark ? '#1e293b' : '#ffffff',
                // Warna Teks menyesuaikan mode
                color: isDark ? '#f8fafc' : '#1e293b',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border ' + (isDark ? 'border-slate-700' : 'border-transparent'),
                    confirmButton: 'px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm',
                    cancelButton: 'px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm text-gray-800 dark:text-gray-200'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-logout').submit();
                }
            })
        }
    </script>
</body>
</html>
