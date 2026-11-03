<x-admin-layout>
    <x-slot:title>
        Profil Saya - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 w-full transition-colors">

        <!-- HEADER COMPACT -->
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 shrink-0">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-slate-100 transition-colors">Profil Saya</h1>
                <p class="text-xs text-gray-500 dark:text-slate-400 transition-colors">
                    {{ auth()->user()->role === 'admin' ? 'Informasi akun dan pengaturan keamanan kata sandi Anda.' : 'Informasi detail akun Anda.' }}
                </p>
            </div>
        </div>

        @if(auth()->user()->role === 'admin')
            <!-- ==========================================
                 TAMPILAN ADMIN (KIRI: STATIS, KANAN: FORM SANDI)
                 ========================================== -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-stretch">

                <!-- KOLOM KIRI: INFORMASI AKUN ADMIN (STATIS) -->
                <div class="lg:col-span-5 bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col transition-colors">
                    <div class="flex items-center gap-2.5 mb-6 pb-2.5 border-b border-gray-100 dark:border-slate-700">
                        <div class="w-8 h-8 rounded-lg bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0">
                            <i class="ph ph-user-circle text-lg"></i>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Informasi Akun</h3>
                    </div>

                    <div class="flex flex-col items-center text-center mb-6">
                        <div class="w-20 h-20 rounded-full bg-purple-100 dark:bg-purple-500/20 text-purple-600 dark:text-purple-400 flex items-center justify-center font-black text-3xl mb-3 shadow-inner border-[3px] border-white dark:border-slate-800">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-slate-100 leading-tight mb-1">{{ $user->name }}</h2>
                        <span class="px-2.5 py-1 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-[9px] font-bold rounded-full uppercase tracking-wider inline-block">
                            Administrator Utama
                        </span>
                    </div>

                    <div class="w-full space-y-2.5 text-left mt-auto">
                        <div class="flex items-center gap-3 p-2.5 bg-gray-50 dark:bg-slate-900/50 rounded-xl border border-gray-100 dark:border-slate-700/50 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-white dark:bg-slate-800 flex items-center justify-center text-gray-500 dark:text-slate-400 shadow-sm shrink-0">
                                <i class="ph ph-envelope-simple text-base"></i>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-[9px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">Alamat Email Login</p>
                                <p class="text-xs font-semibold text-gray-800 dark:text-slate-200 truncate">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-2.5 bg-gray-50 dark:bg-slate-900/50 rounded-xl border border-gray-100 dark:border-slate-700/50 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-white dark:bg-slate-800 flex items-center justify-center text-gray-500 dark:text-slate-400 shadow-sm shrink-0">
                                <i class="ph ph-calendar-blank text-base"></i>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-[9px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">Tanggal Terdaftar</p>
                                <p class="text-xs font-semibold text-gray-800 dark:text-slate-200 truncate">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN: FORM GANTI PASSWORD -->
                <div class="lg:col-span-7 bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col justify-between transition-colors">
                    <form action="{{ route('profil.update') }}" method="POST" class="flex flex-col h-full">
                        @csrf
                        @method('PUT')

                        <div>
                            <div class="flex items-center gap-2.5 mb-6 pb-2.5 border-b border-gray-100 dark:border-slate-700">
                                <div class="w-8 h-8 rounded-lg bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 flex items-center justify-center shrink-0">
                                    <i class="ph ph-shield-check text-lg"></i>
                                </div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Keamanan & Kata Sandi</h3>
                            </div>

                            <div class="bg-blue-50 dark:bg-blue-500/10 border border-blue-100 dark:border-blue-500/20 p-3 rounded-xl mb-5 flex items-center gap-3">
                                <i class="ph ph-info text-blue-500 text-lg shrink-0"></i>
                                <p class="text-[11px] text-blue-700 dark:text-blue-400 mb-0">
                                    Ganti Sandi anda demi keamanan akun anda!
                                </p>
                            </div>

                            <div class="space-y-4">
                                <div x-data="{ show: false }">
                                    <label class="block text-[11px] font-bold text-gray-600 dark:text-slate-400 uppercase mb-1.5">Kata Sandi Lama <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input :type="show ? 'text' : 'password'" name="current_password" required placeholder="Masukkan kata sandi saat ini" readonly onfocus="this.removeAttribute('readonly');" class="w-full px-3.5 py-2.5 pr-10 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-800 dark:text-slate-200 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-red-500 outline-none text-xs transition placeholder-gray-400 dark:placeholder-slate-500">
                                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500 transition-colors">
                                            <i class="text-base" :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div x-data="{ show: false }">
                                        <label class="block text-[11px] font-bold text-gray-600 dark:text-slate-400 uppercase mb-1.5">Kata Sandi Baru <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input :type="show ? 'text' : 'password'" name="new_password" required placeholder="Minimal 4 karakter" readonly onfocus="this.removeAttribute('readonly');" class="w-full px-3.5 py-2.5 pr-10 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-800 dark:text-slate-200 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-red-500 outline-none text-xs transition placeholder-gray-400 dark:placeholder-slate-500">
                                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500 transition-colors">
                                                <i class="text-base" :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div x-data="{ show: false }">
                                        <label class="block text-[11px] font-bold text-gray-600 dark:text-slate-400 uppercase mb-1.5">Konfirmasi Sandi Baru <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input :type="show ? 'text' : 'password'" name="new_password_confirmation" required placeholder="Ulangi sandi baru" readonly onfocus="this.removeAttribute('readonly');" class="w-full px-3.5 py-2.5 pr-10 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-800 dark:text-slate-200 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-red-500 outline-none text-xs transition placeholder-gray-400 dark:placeholder-slate-500">
                                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500 transition-colors">
                                                <i class="text-base" :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-100 dark:border-slate-700/60">
                            <button type="submit" class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-xl text-xs font-bold transition-colors flex items-center justify-center gap-2 shadow-sm">
                                <i class="ph ph-key text-base"></i>
                                <span>Perbarui Kata Sandi</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        @else
            <!-- ==========================================
                 TAMPILAN PETUGAS: PROFIL STATIS COMPACT
                 ========================================== -->
            <div class="flex-1 flex items-center justify-center m-0 p-0">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 w-full max-w-sm flex flex-col items-center text-center transition-colors">

                    <div class="w-16 h-16 rounded-full bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 flex items-center justify-center font-black text-2xl mb-3 shadow-inner border-[3px] border-white dark:border-slate-800">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <h2 class="text-lg font-bold text-gray-900 dark:text-slate-100 leading-tight mb-1">{{ $user->name }}</h2>
                    <span class="px-2.5 py-1 bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-400 text-[9px] font-bold rounded-full uppercase tracking-wider mb-5 inline-block">
                        Petugas Perpustakaan
                    </span>

                    <div class="w-full space-y-2.5 text-left">
                        <div class="flex items-center gap-3 p-2.5 bg-gray-50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-700/50 transition-colors">
                            <div class="w-8 h-8 rounded-xl bg-white dark:bg-slate-800 flex items-center justify-center text-gray-500 dark:text-slate-400 shadow-sm shrink-0">
                                <i class="ph ph-envelope-simple text-base"></i>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-[9px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">Alamat Email</p>
                                <p class="text-xs font-semibold text-gray-800 dark:text-slate-200 truncate">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-2.5 bg-gray-50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-700/50 transition-colors">
                            <div class="w-8 h-8 rounded-xl bg-white dark:bg-slate-800 flex items-center justify-center text-gray-500 dark:text-slate-400 shadow-sm shrink-0">
                                <i class="ph ph-calendar-blank text-base"></i>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-[9px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">Tanggal Terdaftar</p>
                                <p class="text-xs font-semibold text-gray-800 dark:text-slate-200 truncate">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-gray-100 dark:border-slate-700/50 w-full">
                        <p class="text-[10px] text-gray-500 dark:text-slate-400 flex items-center justify-center gap-1.5">
                            <i class="ph ph-info text-blue-500 text-sm shrink-0"></i>
                            Hubungi Administrator untuk perubahan.
                        </p>
                    </div>
                </div>
            </div>
        @endif

    </div>
</x-admin-layout>
