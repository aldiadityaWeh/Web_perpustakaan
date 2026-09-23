<x-admin-layout>
    <x-slot:title>
        Profil Saya - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 min-h-[85vh] w-full max-w-5xl mx-auto">

        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi data diri dan keamanan akun Anda.</p>
        </div>

        <!-- NOTIFIKASI SUKSES -->
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 text-emerald-700 p-4 rounded-xl flex items-center gap-3 border border-emerald-100 shadow-sm">
                <i class="ph ph-check-circle text-xl"></i>
                <p class="text-sm font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('profil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-8">

                <!-- BAGIAN 1: DATA DIRI (Lebar 7 kolom) -->
                <div class="md:col-span-7 bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 h-fit">

                    <!-- Header Kotak Data Diri -->
                    <div class="flex items-center gap-3.5 mb-6 pb-4 border-b border-gray-100">
                        <!-- Background diubah jadi ungu pekat (bg-purple-600) agar ikon putih terlihat jelas -->
                        <div class="w-12 h-12 rounded-xl bg-purple-600 flex items-center justify-center shadow-inner shrink-0">
                            <img src="{{ asset('images/profil.png') }}" alt="Informasi Akun" class="w-6 h-6 object-contain">
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Informasi Akun</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Ubah nama lengkap dan alamat email login.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Nama Lengkap Admin <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none text-sm transition shadow-sm">
                            @error('name') <span class="text-xs text-red-500 mt-1 block">Nama lengkap wajib diisi.</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none text-sm transition shadow-sm">
                            @error('email') <span class="text-xs text-red-500 mt-1 block">Format email tidak valid atau email sudah digunakan.</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 2: KEAMANAN (Lebar 5 kolom) -->
                <div class="md:col-span-5 bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 h-fit">

                    <!-- Header Kotak Keamanan -->
                    <div class="flex items-center gap-3.5 mb-6 pb-4 border-b border-gray-100">
                        <!-- Background diubah jadi merah pekat (bg-red-500) agar ikon putih terlihat jelas -->
                        <div class="w-12 h-12 rounded-xl bg-purple-600  flex items-center justify-center shadow-inner shrink-0">
                            <img src="{{ asset('images/key.png') }}" alt="Keamanan" class="w-6 h-6 object-contain">
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Ganti Password</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Kosongkan jika tidak diubah.</p>
                        </div>
                    </div>

                    <div class="space-y-5">

                        <!-- Form Password Lama dengan Ikon Mata -->
                        <div x-data="{ show: false }">
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Password Lama</label>
                            <div class="relative">
                                <input :type="show ? 'text' : 'password'" name="current_password" placeholder="••••••••"
                                    class="w-full px-4 py-2.5 pr-12 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-600 focus:border-red-600 outline-none text-sm transition shadow-sm">
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-red-600 transition-colors">
                                    <i class="text-lg" :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'"></i>
                                </button>
                            </div>
                            @error('current_password') <span class="text-xs text-red-500 mt-1 block">Password lama yang Anda masukkan salah.</span> @enderror
                        </div>

                        <!-- Form Password Baru dengan Ikon Mata -->
                        <div x-data="{ show: false }">
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Password Baru</label>
                            <div class="relative">
                                <input :type="show ? 'text' : 'password'" name="new_password" placeholder="Minimal 8 karakter"
                                    class="w-full px-4 py-2.5 pr-12 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-600 focus:border-red-600 outline-none text-sm transition shadow-sm">
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-red-600 transition-colors">
                                    <i class="text-lg" :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'"></i>
                                </button>
                            </div>
                            @error('new_password') <span class="text-xs text-red-500 mt-1 block">Password baru minimal 8 karakter atau konfirmasi tidak cocok.</span> @enderror
                        </div>

                        <!-- Form Konfirmasi Password Baru dengan Ikon Mata -->
                        <div x-data="{ show: false }">
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Konfirmasi Password Baru</label>
                            <div class="relative">
                                <input :type="show ? 'text' : 'password'" name="new_password_confirmation" placeholder="Ulangi password baru"
                                    class="w-full px-4 py-2.5 pr-12 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-600 focus:border-red-600 outline-none text-sm transition shadow-sm">
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-red-600 transition-colors">
                                    <i class="text-lg" :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- TOMBOL SIMPAN -->
            <div class="flex justify-end mb-8">
                <button type="submit" class="bg-[#7c3aed] hover:bg-purple-700 text-white px-8 py-3 rounded-xl text-sm font-semibold transition-colors flex items-center justify-center gap-2 shadow-sm">
                    <img src="{{ asset('images/unduh.png') }}" alt="Simpan" class="w-4 h-4 object-contain brightness-200">
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>
