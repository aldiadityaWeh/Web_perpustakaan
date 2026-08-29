<x-admin-layout>
    <x-slot:title>
        Data Peminjaman - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col h-full min-h-full">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Data Peminjaman</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola transaksi peminjaman buku</p>
            </div>
            
            <!-- Tombol Tambah Peminjaman -->
            <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                <i class="ph ph-plus text-lg"></i>
                Tambah Peminjaman
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="bg-purple-50/50 border-b border-gray-100 text-gray-500 text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-4 px-6">JUDUL BUKU</th>
                            <th class="py-4 px-6">PEMINJAM</th>
                            <th class="py-4 px-6">TANGGAL PINJAM</th>
                            <th class="py-4 px-6">TANGGAL KEMBALI</th>
                            <th class="py-4 px-6">STATUS</th>
                            <th class="py-4 px-6 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Empty State View -->
                        <tr>
                            <td colspan="6" class="py-24 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <!-- Ikon Jabat Tangan (Handshake) sesuai dengan referensi gambar -->
                                    <i class="ph ph-handshake text-6xl mb-4 text-gray-300"></i>
                                    <p class="text-sm font-medium text-gray-500">Belum ada data peminjaman</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <footer class="bg-purple-800 text-white p-5 rounded-xl flex flex-col sm:flex-row justify-between items-center gap-4 text-sm mt-auto shadow-md">
            <div class="text-center sm:text-left">
                <p class="font-bold text-base mb-0.5">Sistem Perpustakaan Sekolah</p>
                <p class="text-purple-300 text-xs tracking-wide">&copy; 2026 - Sistem Dibangun oleh Agung Prastiyo</p>
            </div>
            <div class="flex gap-5 text-xl">
                <a href="#" class="text-purple-200 hover:text-white transition-colors" title="Github">
                    <i class="ph ph-github-logo"></i>
                </a>
                <a href="#" class="text-purple-200 hover:text-white transition-colors" title="Bantuan">
                    <i class="ph ph-question"></i>
                </a>
            </div>
        </footer>
        
    </div>
</x-admin-layout>