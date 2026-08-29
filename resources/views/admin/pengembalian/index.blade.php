<x-admin-layout>
    @slot('title')
        Data Pengembalian - Sistem Perpustakaan
    @endslot

    <div class="flex flex-col h-full min-h-full">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Data Pengembalian</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola transaksi pengembalian buku</p>
            </div>
            <!-- Di UI pengembalian tidak ada tombol tambah (karena pengembalian biasanya diproses dari data peminjaman) -->
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead>
                        <tr class="bg-purple-50/50 border-b border-gray-100 text-gray-500 text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-4 px-6">ID PEMINJAMAN</th>
                            <th class="py-4 px-6 text-center">TANGGAL KEMBALI</th>
                            <th class="py-4 px-6 text-center">DENDA</th>
                            <th class="py-4 px-6 text-center">KONDISI BUKU</th>
                            <th class="py-4 px-6 text-center">PETUGAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Empty State View -->
                        <tr>
                            <td colspan="5" class="py-24 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <!-- Ikon panah melingkar (clock counter-clockwise) sesuai dengan referensi gambar -->
                                    <i class="ph ph-clock-counter-clockwise text-6xl mb-4 text-gray-300"></i>
                                    <p class="text-sm font-medium text-gray-500">Belum ada data pengembalian</p>
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
