<x-admin-layout>
    <x-slot:title>
        Dashboard - Sistem Perpustakaan
    </x-slot:title>

    <!-- Notifikasi Sukses Login -->
    <div x-data="{ show: true }" x-show="show" class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-2">
            <i class="ph ph-check-circle text-xl text-emerald-600"></i>
            <span class="text-sm font-medium">Login berhasil</span>
        </div>
        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
            <i class="ph ph-x text-lg"></i>
        </button>
    </div>

    <!-- Judul Halaman -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-sm text-gray-500 mt-1">Ringkasan data dan statistik perpustakaan</p>
    </div>

    <!-- 4 Cards Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

        <!-- Total Buku -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Buku</p>
                <h3 class="text-3xl font-extrabold text-gray-800">0</h3>
            </div>
            <div class="h-12 w-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl">
                <i class="ph ph-book"></i>
            </div>
        </div>

        <!-- Total Anggota -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Anggota</p>
                <h3 class="text-3xl font-extrabold text-gray-800">0</h3>
            </div>
            <div class="h-12 w-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl">
                <i class="ph ph-users"></i>
            </div>
        </div>

        <!-- Sedang Dipinjam -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Sedang Dipinjam</p>
                <h3 class="text-3xl font-extrabold text-gray-800">0</h3>
            </div>
            <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl">
                <i class="ph ph-handshake"></i>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Transaksi</p>
                <h3 class="text-3xl font-extrabold text-gray-800">0</h3>
            </div>
            <div class="h-12 w-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl">
                <i class="ph ph-arrows-left-right"></i>
            </div>
        </div>

    </div>

    <!-- Grafik / Informasi Bawah -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 min-h-[300px]">
            <h3 class="font-bold text-gray-800 text-base mb-4">Statistik Peminjaman 30 Hari Terakhir</h3>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 min-h-[300px]">
            <h3 class="font-bold text-gray-800 text-base mb-4">Distribusi Kategori Buku</h3>
        </div>
    </div>

</x-admin-layout>
