<x-admin-layout>
    <x-slot:title>
        Profil Saya - Sistem Perpustakaan
    </x-slot:title>

    <div class="flex flex-col flex-1 min-h-[85vh] w-full max-w-5xl mx-auto">

        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Profil Saya</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi data diri dan keamanan akun Anda.</p>
        </div>

        <!-- NOTIFIKASI -->
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 text-emerald-700 p-4 rounded-xl flex items-center gap-3 border border-emerald-100">
                <i class="ph ph-check-circle text-xl"></i>
                <p class="text-sm font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('profil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-8">

                <!-- BAGIAN 1: DATA DIRI (Lebar 7 kolom) -->
                <div class="md:col-span-7 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-fit">
                    <h3 class="text-base font-bold text-gray-800 mb-1 flex items-center gap-2">
                        <i class="ph ph-user-circle text-purple-600 text-lg"></i> Informasi Akun
                    </h3>
                    <p class="text-xs text-gray-500 mb-6">Ubah nama lengkap dan alamat email yang digunakan untuk login.</p>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Nama Lengkap Admin <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none text-sm transition">
                            @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none text-sm transition">
                            @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 2: KEAMANAN (Lebar 5 kolom) -->
                <div class="md:col-span-5 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-fit">
                    <h3 class="text-base font-bold text-gray-800 mb-1 flex items-center gap-2">
                        <i class="ph ph-lock-key text-red-600 text-lg"></i> Ganti Password
                    </h3>
                    <p class="text-xs text-gray-500 mb-6">Kosongkan bagian ini jika Anda tidak ingin mengubah password.</p>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Password Lama</label>
                            <input type="password" name="current_password" placeholder="••••••••"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-red-600 focus:border-red-600 outline-none text-sm transition">
                            @error('current_password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Password Baru</label>
                            <input type="password" name="new_password" placeholder="Minimal 8 karakter"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-red-600 focus:border-red-600 outline-none text-sm transition">
                            @error('new_password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1.5">Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" placeholder="Ulangi password baru"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-red-600 focus:border-red-600 outline-none text-sm transition">
                        </div>
                    </div>
                </div>

            </div>

            <!-- TOMBOL SIMPAN -->
            <div class="flex justify-end mb-8">
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-10 py-3 rounded-xl text-sm font-bold transition-colors flex items-center justify-center gap-2 shadow-md">
                    <i class="ph ph-floppy-disk text-lg"></i> Simpan Perubahan
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>
