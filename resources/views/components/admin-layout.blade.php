<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistem Perpustakaan' }}</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Alpine.js untuk interaksi Toggle Sidebar & Mobile Drawer -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased overflow-hidden">

    <!-- Alpine x-data -->
    <div x-data="{ desktopOpen: true, mobileOpen: false }" class="flex h-screen w-full relative">

        <!-- ================= BACKDROP OVERLAY UNTUK MOBILE ================= -->
        <div
            x-show="mobileOpen"
            @click="mobileOpen = false"
            x-transition.opacity
            class="fixed inset-0 bg-black/50 z-30 lg:hidden"
            style="display: none;"
        ></div>

        <!-- ================= SIDEBAR ================= -->
        <aside
            class="bg-white border-r border-gray-200 flex flex-col transition-all duration-300 ease-in-out shrink-0 shadow-sm z-40 fixed lg:static inset-y-0 left-0"
            :class="{
                'w-64': desktopOpen,
                'w-20': !desktopOpen,
                '-translate-x-full lg:translate-x-0': !mobileOpen,
                'translate-x-0 w-64': mobileOpen
            }"
        >
            <!-- Sidebar Header / Profil Singkat -->
            <div class="p-4 border-b border-gray-100 flex items-center justify-between gap-3 h-16">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="h-10 w-10 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-lg shrink-0">
                        <i class="ph ph-user"></i>
                    </div>
                    <div x-show="desktopOpen || mobileOpen" x-transition.opacity class="overflow-hidden whitespace-nowrap">
                        <p class="font-bold text-sm text-gray-800 leading-none">Administrator</p>
                        <p class="text-xs text-gray-400 mt-1">Administrator</p>
                    </div>
                </div>
                <button @click="mobileOpen = false" class="lg:hidden text-gray-400 hover:text-gray-600">
                    <i class="ph ph-x text-xl"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto py-4 px-3 flex flex-col gap-1">

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-purple-100 text-purple-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="ph ph-squares-four text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Dashboard</span>
                </a>

                <!-- Manajemen Data Group -->
                <div x-show="desktopOpen || mobileOpen" class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mt-4 mb-1 px-3">Manajemen Data</div>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-100">
                    <i class="ph ph-book text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Data Buku</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-100">
                    <i class="ph ph-users text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Data Anggota</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-100">
                    <i class="ph ph-handshake text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Peminjaman</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-100">
                    <i class="ph ph-clock-counter-clockwise text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Pengembalian</span>
                </a>

                <!-- Manajemen Transaksi Group -->
                <div x-show="desktopOpen || mobileOpen" class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mt-4 mb-1 px-3">Transaksi</div>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-100">
                    <i class="ph ph-receipt text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Riwayat Transaksi</span>
                </a>

                <!-- Manajemen Laporan Group -->
                <div x-show="desktopOpen || mobileOpen" class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mt-4 mb-1 px-3">Laporan</div>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-100">
                    <i class="ph ph-chart-line-up text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Laporan Perpustakaan</span>
                </a>

                <!-- Manajemen Sistem Group -->
                <div x-show="desktopOpen || mobileOpen" class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mt-4 mb-1 px-3">Manajemen Sistem</div>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-100">
                    <i class="ph ph-user-gear text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Kelola User</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-100">
                    <i class="ph ph-gear text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Pengaturan</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-100">
                    <i class="ph ph-user-circle text-2xl shrink-0"></i>
                    <span x-show="desktopOpen || mobileOpen" x-transition.opacity class="whitespace-nowrap">Profil Saya</span>
                </a>

            </nav>
        </aside>

        <!-- ================= MAIN CONTENT AREA ================= -->
        <div class="flex-1 flex flex-col overflow-hidden w-full">

            <!-- Topbar (Ungu) -->
            <header class="h-16 bg-[#7c3aed] text-white flex items-center justify-between px-4 sm:px-6 shadow-md z-10 shrink-0">

                <div class="flex items-center gap-3 sm:gap-4">
                    <button
                        @click="if (window.innerWidth >= 1024) { desktopOpen = !desktopOpen; } else { mobileOpen = !mobileOpen; }"
                        class="text-white hover:bg-purple-700 p-2 rounded-lg transition-colors focus:outline-none"
                    >
                        <i class="ph ph-list text-2xl"></i>
                    </button>
                    <span class="font-bold text-base sm:text-lg tracking-wide flex items-center gap-2 truncate">
                        <i class="ph ph-book-open shrink-0"></i> <span class="truncate">Sistem Perpustakaan</span>
                    </span>
                </div>

                <!-- Right Header: User Profile & Tombol Keluar -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <!-- Menggunakan flex dengan breakpoint md:flex, tanpa kelas hidden yang konflik -->
                    <div class="items-center gap-2 text-sm hidden md:flex">
                        <i class="ph ph-user-circle text-xl"></i>
                        <span class="font-medium">Administrator</span>
                    </div>

                    <!-- Tombol Keluar -->
                    <a href="{{ route('login') }}" class="bg-purple-800 hover:bg-purple-900 text-white px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition flex items-center gap-2 shadow-sm border border-purple-600 shrink-0">
                        <i class="ph ph-sign-out text-base sm:text-lg"></i>
                        <span>Keluar</span>
                    </a>
                </div>
            </header>

            <!-- Page Content (Slot) -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 sm:p-6">
                {{ $slot }}
            </main>
        </div>

    </div>

</body>
</html>
