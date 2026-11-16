<x-admin-layout>
    <x-slot:title>Pengaturan Sistem - Sistem Perpustakaan</x-slot:title>

    @php
        $inputClass = 'w-full px-3 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-800 dark:text-slate-200 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-purple-600 outline-none text-xs transition';
        $labelClass = 'block text-[11px] font-bold text-gray-600 dark:text-slate-400 uppercase mb-1';
    @endphp

    <div x-data="{ modalPetugas: false, modalEdit: false, editId: '', editName: '', editEmail: '' }" class="flex flex-col w-full transition-colors">
        <!-- HEADER COMPACT -->
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-slate-100 transition-colors">Pengaturan Sistem</h1>
                <p class="text-xs text-gray-500 dark:text-slate-400 transition-colors">Kelola identitas perpustakaan, aturan sirkulasi, dan akun petugas.</p>
            </div>
        </div>

        <!-- GRID UTAMA: 2 KOLOM -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">

            <!-- KOLOM KIRI (7/12): FORM IDENTITAS & SIRKULASI -->
            <form action="{{ route('pengaturan.update') }}" method="POST" class="lg:col-span-7 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-5 transition-colors space-y-4">
                @csrf @method('PUT')

                <!-- BAGIAN 1: IDENTITAS SEKOLAH -->
                <div>
                    <div class="flex items-center gap-2.5 mb-3 pb-2.5 border-b border-gray-100 dark:border-slate-700">
                        <div class="w-8 h-8 rounded-lg bg-purple-50 dark:bg-purple-500/10 flex items-center justify-center text-purple-600 dark:text-purple-400 shrink-0"><i class="ph ph-buildings text-lg"></i></div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Identitas Sekolah</h3>
                    </div>

                    <div class="space-y-3">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="{{ $labelClass }}">Nama Sekolah / Perpus <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $pengaturan->nama_sekolah) }}" required class="{{ $inputClass }}">
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">Alamat Lengkap</label>
                                <input type="text" name="alamat_sekolah" value="{{ old('alamat_sekolah', $pengaturan->alamat_sekolah) }}" placeholder="Jl. Cikopak No. 53, Sadang..." class="{{ $inputClass }}">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="{{ $labelClass }}">Nama Kepala Sekolah</label>
                                <input type="text" name="kepala_sekolah" value="{{ old('kepala_sekolah', $pengaturan->kepala_sekolah) }}" placeholder="Contoh: Drs. H. Ahmad, M.Pd." class="{{ $inputClass }}">
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">NIP Kepala Sekolah</label>
                                <input type="text" name="nip_kepala_sekolah" value="{{ old('nip_kepala_sekolah', $pengaturan->nip_kepala_sekolah) }}" placeholder="NIP Kepala Sekolah" class="{{ $inputClass }}">
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">Nama Kepala Perpus</label>
                                <input type="text" name="kepala_perpustakaan" value="{{ old('kepala_perpustakaan', $pengaturan->kepala_perpustakaan) }}" placeholder="Nama Kepala Perpustakaan" class="{{ $inputClass }}">
                            </div>
                            <div>
                                <label class="{{ $labelClass }}">NIP Kepala Perpus</label>
                                <input type="text" name="nip_kepala" value="{{ old('nip_kepala', $pengaturan->nip_kepala) }}" placeholder="NIP Kepala Perpustakaan" class="{{ $inputClass }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 2: ATURAN SIRKULASI -->
                <div class="pt-2">
                    <div class="flex items-center gap-2.5 mb-3 pb-2.5 border-b border-gray-100 dark:border-slate-700">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0"><i class="ph ph-arrows-left-right text-lg"></i></div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Aturan Sirkulasi & Denda</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="{{ $labelClass }}">Denda / Hari (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="denda_per_hari" value="{{ old('denda_per_hari', $pengaturan->denda_per_hari) }}" min="0" required class="w-full px-3 py-2 border border-red-200 dark:border-red-500/30 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-purple-600 outline-none text-xs font-bold text-red-600 dark:text-red-400 bg-red-50/50 dark:bg-red-500/10">
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Batas Pinjam <span class="text-red-500">*</span></label>
                            <div class="relative flex items-center">
                                <input type="number" name="maksimal_hari_pinjam" value="{{ old('maksimal_hari_pinjam', $pengaturan->maksimal_hari_pinjam) }}" min="1" required class="{{ $inputClass }} pr-12">
                                <span class="absolute right-3 text-[11px] font-semibold text-gray-400">Hari</span>
                            </div>
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Maks. Buku <span class="text-red-500">*</span></label>
                            <div class="relative flex items-center">
                                <input type="number" name="maksimal_buku_pinjam" value="{{ old('maksimal_buku_pinjam', $pengaturan->maksimal_buku_pinjam) }}" min="1" required class="{{ $inputClass }} pr-12">
                                <span class="absolute right-3 text-[11px] font-semibold text-gray-400">Buku</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-3 border-t border-gray-100 dark:border-slate-700">
                    <button type="submit" class="w-full sm:w-auto bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-xl text-xs font-semibold transition-colors flex items-center justify-center gap-1.5 shadow-sm cursor-pointer">
                        <i class="ph ph-floppy-disk text-base"></i><span>Simpan Pengaturan</span>
                    </button>
                </div>
            </form>

            <!-- KOLOM KANAN (5/12): MANAJEMEN AKUN PETUGAS -->
            <div class="lg:col-span-5 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-5 transition-colors flex flex-col">
                <div class="flex items-center justify-between gap-2 mb-3 pb-2.5 border-b border-gray-100 dark:border-slate-700">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shrink-0"><i class="ph ph-users-three text-lg"></i></div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Akun Petugas</h3>
                    </div>
                    <button type="button" @click="modalPetugas = true" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-xl text-xs font-bold transition-colors flex items-center gap-1.5 shadow-sm shrink-0 cursor-pointer">
                        <i class="ph ph-user-plus text-sm"></i><span>Tambah</span>
                    </button>
                </div>

                <!-- Tabel Daftar Petugas -->
                <div class="overflow-y-auto max-h-[340px] pr-1">
                    <table class="w-full text-left border-collapse">
                        <thead class="sticky top-0 bg-white dark:bg-slate-800">
                            <tr class="border-b border-gray-100 dark:border-slate-700 text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase">
                                <th class="py-2 px-2">Petugas</th>
                                <th class="py-2 px-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700/60 text-xs">
                            @foreach($petugas as $user)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/20 transition-colors">
                                    <td class="py-2.5 px-2">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-full bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold text-[11px] shrink-0">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div class="truncate max-w-[150px] sm:max-w-[190px]">
                                                <div class="font-semibold text-gray-800 dark:text-slate-200 flex items-center gap-1.5">
                                                    <span class="truncate">{{ $user->name }}</span>
                                                    @if(auth()->id() == $user->id)
                                                        <span class="text-[9px] bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 px-1.5 py-0.5 rounded-full font-bold shrink-0">Admin</span>
                                                    @endif
                                                </div>
                                                <div class="text-[11px] text-gray-400 dark:text-slate-500 truncate">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-2 text-right align-middle whitespace-nowrap">
                                        @if(auth()->id() != $user->id)
                                            <button type="button" @click="modalEdit = true; editId = '{{ $user->id }}'; editName = '{{ addslashes($user->name) }}'; editEmail = '{{ addslashes($user->email) }}'" class="text-amber-500 hover:text-amber-700 bg-amber-50 dark:bg-amber-500/10 hover:bg-amber-100 p-1.5 rounded-lg transition-colors inline-block mr-1 cursor-pointer" title="Edit / Reset Password">
                                                <i class="ph ph-key text-sm"></i>
                                            </button>
                                            <form action="{{ route('pengaturan.petugas.destroy', $user->id) }}" method="POST" id="delete-form-petugas-{{ $user->id }}" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="button" onclick="konfirmasiHapusPetugas('{{ $user->id }}')" class="text-red-500 hover:text-red-700 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 p-1.5 rounded-lg transition-colors cursor-pointer" title="Hapus Petugas">
                                                    <i class="ph ph-trash text-sm"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[10px] text-gray-400 dark:text-slate-500 italic px-1">Kelola di Profil</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- MODAL 1: TAMBAH PETUGAS BARU -->
        <div x-show="modalPetugas" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="modalPetugas = false" x-transition class="bg-white dark:bg-slate-800 rounded-2xl max-w-sm w-full p-5 shadow-2xl border border-gray-100 dark:border-slate-700">
                <div class="flex items-center justify-between mb-4 pb-2.5 border-b border-gray-100 dark:border-slate-700">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400"><i class="ph ph-user-plus text-lg"></i></div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Tambah Petugas Baru</h3>
                    </div>
                    <button type="button" @click="modalPetugas = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-slate-300 cursor-pointer"><i class="ph ph-x text-base"></i></button>
                </div>

                <form action="{{ route('pengaturan.petugas.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="{{ $labelClass }}">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required placeholder="Masukkan nama petugas" class="{{ $inputClass }} focus:ring-emerald-600">
                    </div>
                    <div>
                        <label class="{{ $labelClass }}">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required placeholder="petugas@sdn6ciseureuh.sch.id" class="{{ $inputClass }} focus:ring-emerald-600">
                    </div>
                    <div>
                        <label class="{{ $labelClass }}">Kata Sandi <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required placeholder="Minimal 4 karakter" class="{{ $inputClass }} focus:ring-emerald-600">
                    </div>
                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-slate-700">
                        <button type="button" @click="modalPetugas = false" class="px-3.5 py-2 rounded-xl text-xs font-bold text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition cursor-pointer">Batal</button>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer"><i class="ph ph-check text-sm"></i><span>Simpan</span></button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL 2: EDIT & RESET PASSWORD PETUGAS -->
        <div x-show="modalEdit" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="modalEdit = false" x-transition class="bg-white dark:bg-slate-800 rounded-2xl max-w-sm w-full p-5 shadow-2xl border border-gray-100 dark:border-slate-700">
                <div class="flex items-center justify-between mb-4 pb-2.5 border-b border-gray-100 dark:border-slate-700">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center text-amber-600 dark:text-amber-400"><i class="ph ph-key text-lg"></i></div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Edit & Reset Sandi Petugas</h3>
                    </div>
                    <button type="button" @click="modalEdit = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-slate-300 cursor-pointer"><i class="ph ph-x text-base"></i></button>
                </div>

                <form :action="'{{ url('/admin/pengaturan/petugas') }}/' + editId" method="POST" class="space-y-3">
                    @csrf @method('PUT')
                    <div>
                        <label class="{{ $labelClass }}">Nama Petugas <span class="text-red-500">*</span></label>
                        <input type="text" name="name" x-model="editName" required class="{{ $inputClass }} focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="{{ $labelClass }}">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" x-model="editEmail" required class="{{ $inputClass }} focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="{{ $labelClass }}">Reset Kata Sandi Baru</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak ingin diubah" class="{{ $inputClass }} focus:ring-amber-500">
                        <p class="text-[10px] text-gray-400 dark:text-slate-500 mt-1">Isi minimal 4 karakter untuk mengganti sandi petugas ini.</p>
                    </div>
                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-slate-700">
                        <button type="button" @click="modalEdit = false" class="px-3.5 py-2 rounded-xl text-xs font-bold text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition cursor-pointer">Batal</button>
                        <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer"><i class="ph ph-check text-sm"></i><span>Perbarui</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function konfirmasiHapusPetugas(id) {
            const isDark = document.documentElement.classList.contains('dark');
            Swal.fire({
                title: 'Hapus Akun Petugas?',
                text: "Akses login petugas ini akan dihapus secara permanen dari sistem!",
                icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444',
                cancelButtonColor: isDark ? '#334155' : '#6b7280',
                confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal', reverseButtons: true,
                background: isDark ? '#1e293b' : '#ffffff', color: isDark ? '#f8fafc' : '#1e293b',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border ' + (isDark ? 'border-slate-700' : 'border-transparent'),
                    confirmButton: 'px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm',
                    cancelButton: 'px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm text-gray-800 dark:text-gray-200'
                }
            }).then((result) => {
                if (result.isConfirmed) document.getElementById('delete-form-petugas-' + id).submit();
            });
        }
    </script>
</x-admin-layout>
