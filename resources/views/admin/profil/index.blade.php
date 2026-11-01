<x-admin-layout>
    <x-slot:title>
        Profil Saya - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col w-full transition-colors">

        <!-- HEADER COMPACT (Senada dengan Pengaturan) -->
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-slate-100 transition-colors">Profil Saya</h1>
                <p class="text-xs text-gray-500 dark:text-slate-400 transition-colors">Kelola informasi data diri dan keamanan kata sandi akun Anda.</p>
            </div>
        </div>

        <form action="{{ route('profil.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- GRID 2 KOLOM SEIMBANG (6 KIRI : 6 KANAN) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch">

                <!-- ==========================================
                     KOLOM KIRI (6/12): INFORMASI AKUN
                     ========================================== -->
                <div class="lg:col-span-6 bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col justify-between transition-colors">

                    <div>
                        <!-- Header Kotak Data Diri -->
                        <div class="flex items-center gap-2.5 mb-4 pb-2.5 border-b border-gray-100 dark:border-slate-700 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0">
                                <i class="ph ph-user-circle text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Informasi Akun</h3>
                            </div>
                        </div>

                        <!-- Kartu Mini Ringkasan Akun (Agar tinggi kolom kiri & kanan seimbang) -->
                        <div class="mb-4 p-3 rounded-xl bg-gray-50 dark:bg-slate-900/60 border border-gray-100 dark:border-slate-700/60 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-purple-600 text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="overflow-hidden">
                                <div class="flex items-center gap-2">
                                    <p class="text-xs font-bold text-gray-900 dark:text-slate-100 truncate">{{ $user->name }}</p>
                                    @if($user->id == 1)
                                        <span class="text-[9px] bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 px-2 py-0.5 rounded-full font-bold shrink-0">Admin Utama</span>
                                    @else
                                        <span class="text-[9px] bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-400 px-2 py-0.5 rounded-full font-bold shrink-0">Petugas</span>
                                    @endif
                                </div>
                                <p class="text-[11px] text-gray-400 dark:text-slate-500 truncate mt-0.5">Terdaftar sejak {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</p>
                            </div>
                        </div>

                        <!-- Input Data Diri -->
                        <div class="space-y-3.5">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 dark:text-slate-400 uppercase mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full px-3.5 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-800 dark:text-slate-200 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-purple-600 outline-none text-xs transition">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 dark:text-slate-400 uppercase mb-1">Alamat Email Login <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full px-3.5 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-800 dark:text-slate-200 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-purple-600 outline-none text-xs transition">
                            </div>
                        </div>
                    </div>

                    <p class="text-[10px] text-gray-400 dark:text-slate-500 mt-4 pt-3 border-t border-gray-100 dark:border-slate-700/60">
                        <i class="ph ph-info align-middle mr-1"></i>Pastikan alamat email tetap aktif untuk keperluan masuk ke dalam sistem.
                    </p>
                </div>

                <!-- ==========================================
                     KOLOM KANAN (6/12): GANTI PASSWORD
                     ========================================== -->
                <div class="lg:col-span-6 bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col justify-between transition-colors">

                    <div>
                        <!-- Header Kotak Keamanan -->
                        <div class="flex items-center justify-between gap-2 mb-4 pb-2.5 border-b border-gray-100 dark:border-slate-700 transition-colors">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 flex items-center justify-center shrink-0">
                                    <i class="ph ph-lock-key text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Ganti Kata Sandi</h3>
                                </div>
                            </div>
                            <span class="text-[10px] font-semibold text-gray-400 dark:text-slate-500 bg-gray-100 dark:bg-slate-700/60 px-2 py-0.5 rounded-md">Opsional</span>
                        </div>

                        <div class="space-y-3.5">

                            <!-- Password Lama (Dilengkapi readonly onfocus agar tidak terkena autofill browser) -->
                            <div x-data="{ show: false }">
                                <label class="block text-[11px] font-bold text-gray-600 dark:text-slate-400 uppercase mb-1">Kata Sandi Lama</label>
                                <div class="relative">
                                    <input :type="show ? 'text' : 'password'" name="current_password" placeholder="Isi jika ingin mengganti sandi"
                                        readonly onfocus="this.removeAttribute('readonly');"
                                        class="w-full px-3.5 py-2 pr-10 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-800 dark:text-slate-200 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-red-500 outline-none text-xs transition placeholder-gray-400 dark:placeholder-slate-500">
                                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500 transition-colors">
                                        <i class="text-base" :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Password Baru -->
                            <div x-data="{ show: false }">
                                <label class="block text-[11px] font-bold text-gray-600 dark:text-slate-400 uppercase mb-1">Kata Sandi Baru</label>
                                <div class="relative">
                                    <input :type="show ? 'text' : 'password'" name="new_password" placeholder="Minimal 4 karakter"
                                        readonly onfocus="this.removeAttribute('readonly');"
                                        class="w-full px-3.5 py-2 pr-10 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-800 dark:text-slate-200 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-red-500 outline-none text-xs transition placeholder-gray-400 dark:placeholder-slate-500">
                                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500 transition-colors">
                                        <i class="text-base" :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Konfirmasi Password Baru -->
                            <div x-data="{ show: false }">
                                <label class="block text-[11px] font-bold text-gray-600 dark:text-slate-400 uppercase mb-1">Konfirmasi Sandi Baru</label>
                                <div class="relative">
                                    <input :type="show ? 'text' : 'password'" name="new_password_confirmation" placeholder="Ulangi kata sandi baru"
                                        readonly onfocus="this.removeAttribute('readonly');"
                                        class="w-full px-3.5 py-2 pr-10 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-800 dark:text-slate-200 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-red-500 outline-none text-xs transition placeholder-gray-400 dark:placeholder-slate-500">
                                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500 transition-colors">
                                        <i class="text-base" :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- TOMBOL SIMPAN (Diletakkan di kanan bawah kartu agar hemat ruang vertikal) -->
                    <div class="flex justify-end mt-4 pt-3 border-t border-gray-100 dark:border-slate-700/60">
                        <button type="submit" class="w-full sm:w-auto bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-xl text-xs font-semibold transition-colors flex items-center justify-center gap-1.5 shadow-sm">
                            <i class="ph ph-floppy-disk text-base"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>

                </div>

            </div>
        </form>

    </div>
</x-admin-layout>
