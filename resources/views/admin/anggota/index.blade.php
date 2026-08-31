<x-admin-layout>
    <x-slot:title>
        Data Anggota - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col h-full min-h-full">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Data Anggota</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola data siswa yang terdaftar di perpustakaan</p>
            </div>

            <a href="{{ route('anggota.create') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                <i class="ph ph-plus text-lg"></i>
                Tambah Anggota
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6 flex flex-col md:flex-row gap-4">
            <!-- Search Input -->
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="ph ph-magnifying-glass text-gray-400 text-lg"></i>
                </div>
                <input type="text" placeholder="Cari NIS atau Nama Siswa..."
                    class="pl-11 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-700 placeholder-gray-400">
            </div>

            <!-- Filters -->
            <div class="flex items-center gap-3 shrink-0">
                <div class="relative">
                    <select class="appearance-none pl-4 pr-10 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm bg-white text-gray-700 cursor-pointer w-full md:w-40">
                        <option value="">Semua Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <i class="ph ph-caret-down text-gray-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">

            @if(session('success'))
                <div class="bg-emerald-50 border-b border-emerald-100 p-4 flex items-center gap-3 text-emerald-700 text-sm font-medium">
                    <i class="ph ph-check-circle text-xl"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead>
                        <tr class="bg-purple-50/50 border-b border-gray-100 text-gray-500 text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-4 px-6 w-16 text-center">No</th>
                            <th class="py-4 px-6">NIS</th>
                            <th class="py-4 px-6">NAMA LENGKAP</th>
                            <th class="py-4 px-6">KELAS</th>
                            <th class="py-4 px-6">STATUS</th>
                            <th class="py-4 px-6 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggotas as $anggota)
                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors text-sm">
                            <td class="py-4 px-6 text-gray-600 font-medium text-center">{{ $anggotas->firstItem() + $loop->index }}</td>
                            <td class="py-4 px-6 text-gray-600 font-medium">{{ $anggota->nis }}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                        <i class="ph {{ $anggota->jenis_kelamin == 'L' ? 'ph-gender-male' : 'ph-gender-female text-pink-500' }} text-lg block leading-none"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $anggota->nama_lengkap }}</p>
                                        <p class="text-xs text-gray-500">{{ $anggota->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-gray-600">{{ $anggota->kelas }}</td>
                            <td class="py-4 px-6">
                                @if($anggota->status == 'Aktif')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">Aktif</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Tombol Detail -->
                                    <a href="{{ route('anggota.show', $anggota->id) }}" class="p-2 text-teal-600 hover:bg-teal-50 rounded-lg transition-colors" title="Lihat Detail">
                                        <i class="ph ph-eye text-lg"></i>
                                    </a>
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('anggota.edit', $anggota->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                        <i class="ph ph-pencil-simple text-lg"></i>
                                    </a>

                                    <!-- Tombol Hapus & Modal -->
                                    <div x-data="{ showDeleteModal: false }" class="inline-block">
                                        <button @click="showDeleteModal = true" type="button" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                            <i class="ph ph-trash text-lg"></i>
                                        </button>

                                        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[99] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                                            <div @click.away="showDeleteModal = false" class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl transform transition-all text-left">
                                                <div class="flex items-center gap-4 mb-4">
                                                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xl shrink-0">
                                                        <i class="ph ph-warning-circle block leading-none"></i>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-bold text-gray-900 text-base">Hapus Anggota?</h3>
                                                        <p class="text-xs text-gray-500 mt-1">Data anggota ini akan dihapus permanen.</p>
                                                    </div>
                                                </div>
                                                <div class="flex justify-end gap-3 mt-6">
                                                    <button @click="showDeleteModal = false" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50">Batal</button>
                                                    <form action="{{ route('anggota.destroy', $anggota->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700">Ya, Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <!-- Empty State yang sudah disempurnakan -->
                        <tr>
                            <td colspan="6" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center -mt-4">
                                    <div class="w-24 h-24 rounded-full bg-purple-50 border-8 border-white shadow-sm flex items-center justify-center mb-4">
                                        <i class="ph ph-users text-4xl text-purple-500 block leading-none"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-1">Data Anggota Kosong</h3>
                                    <p class="text-sm font-medium text-gray-500 mb-6">Belum ada siswa yang didaftarkan sebagai anggota.</p>
                                    <a href="{{ route('anggota.create') }}" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                        <i class="ph ph-plus text-lg"></i>
                                        Tambah Anggota Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-100">
                {{ $anggotas->links() }}
            </div>
        </div>

        <footer class="bg-white border-t border-gray-200 text-gray-500 py-4 px-6 rounded-xl flex flex-col sm:flex-row justify-between items-center gap-2 text-xs mt-auto shadow-sm">
            <div class="text-center sm:text-left">
                <p class="font-medium text-gray-600 mb-0.5">Sistem Perpustakaan Sekolah</p>
                <p>&copy; 2026 - Sistem Dibangun oleh Agung Prastiyo</p>
            </div>
            <div class="flex gap-4 text-lg text-gray-400">
                <a href="#" class="hover:text-purple-600 transition-colors" title="Github">
                    <i class="ph ph-github-logo"></i>
                </a>
                <a href="#" class="hover:text-purple-600 transition-colors" title="Bantuan">
                    <i class="ph ph-question"></i>
                </a>
            </div>
        </footer>

    </div>
</x-admin-layout>
