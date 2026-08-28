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
    <!-- Alpine.js untuk interaksi Toggle Sidebar -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased overflow-hidden">

    <!-- Alpine x-data mengontrol status sidebar (terbuka/tertutup) -->
    <div x-data="{ sidebarOpen: true }" class="flex h-screen w-full">

        <!-- ================= SIDEBAR ================= -->
        <aside
            class="bg-white border-r border-gray-200 flex flex-col transition-all duration-300 ease-in-out shrink-0 shadow-sm z-20"
            :class="sidebarOpen ? 'w-64' : 'w-20'"
        >
            <!-- Sidebar Header / Profil Singkat -->
            <div class="p-4 border-b border-gray-100 flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-lg shrink-0">
                    <i class="ph ph-user"></i>
                </div>
                <div x-show="sidebarOpen" x-transition.opacity class="overflow-hidden whitespace-nowrap">
                    <p class="font-bold text-sm text-gray-800 leading-none">Administrator</p>
                    <p class="text-xs text-gray-400 mt-1">Administrator</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto py-4 px-3 flex flex-col gap-1">

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-purple-100 text-purple-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="ph ph-squares-four text-2xl shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Dashboard</span>
                </a>

                <!-- Manajemen Data Group -->
                <div x-show="sidebarOpen" class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mt-4 mb-1 px-3">Manajemen Data</div>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-100">
                    <i class="ph ph-book text-2xl shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Data Buku</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-100">
                    <i class="ph ph-users text-2xl shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Data Anggota</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-100">
                    <i class="ph ph-handshake text-2xl shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Peminjaman</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-100">
                    <i class="ph ph-clock-counter-clockwise text-2xl shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Pengembalian</span>
                </a>

                <!-- Manajemen Sistem Group -->
                <div x-show="sidebarOpen" class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mt-4 mb-1 px-3">Manajemen Sistem</div>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-100">
                    <i class="ph ph-user-gear text-2xl shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Kelola User</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-100">
                    <i class="ph ph-user-circle text-2xl shrink-0"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap">Profil Saya</span>
                </a>

            </nav>
        </aside>

        <!-- ================= MAIN CONTENT AREA ================= -->
        <div class="flex-1 flex flex-col overflow-hidden w-full">

            <!-- Topbar (Ungu) -->
            <header class="h-16 bg-[#7c3aed] text-white flex items-center justify-between px-6 shadow-md z-10">

                <div class="flex items-center gap-4">
                    <!-- Tombol Roll Back / Toggle Sidebar -->
                    <button @click="sidebarOpen = !sidebarOpen" class="text-white hover:bg-purple-700 p-2 rounded-lg transition-colors focus:outline-none">
                        <i class="ph ph-list text-2xl"></i>
                    </button>
                    <span class="font-bold text-lg tracking-wide flex items-center gap-2">
                        <i class="ph ph-book-open"></i> Sistem Perpustakaan
                    </span>
                </div>

                <!-- Right Header Profil & Notifikasi -->
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-2 text-sm">
                        <i class="ph ph-user-circle text-xl"></i>
                        <span class="font-medium">Administrator</span>
                    </div>
                </div>
            </header>

            <!-- Page Content (Slot) -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                {{ $slot }}
            </main>
        </div>

    </div>

</body>
</html>
