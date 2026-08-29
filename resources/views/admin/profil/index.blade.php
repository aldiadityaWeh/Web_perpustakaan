<x-admin-layout>
    @slot('title')
        Profil Saya - Sistem Perpustakaan
    @endslot

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Profil Saya</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi akun dan kata sandi Anda</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">

        <!-- KARTU 1: INFORMASI PROFIL -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <form action="#" method="POST">
                @csrf
                <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl shrink-0">
                        <i class="ph ph-user-circle"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Informasi Akun</h2>
                        <p class="text-xs text-gray-500">Perbarui data profil dan alamat email Anda</p>
                    </div>
                </div>

                <div class="p-6 flex flex-col gap-5">
                    <!-- Foto Profil Ilustrasi -->
                    <div class="flex items-center gap-4 mb-2">
                        <div class="h-20 w-20 rounded-full bg-purple-100 border-4 border-white shadow-sm flex items-center justify-center text-purple-600 text-4xl">
                            <i class="ph ph-user"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Administrator</p>
                            <p class="text-xs text-gray-500">Super Admin</p>
                        </div>
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Tampilan</label>
                        <input type="text" id="name" name="name" value="Administrator" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                    </div>

                    <!-- Username / Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Username / Email Login</label>
                        <input type="text" id="email" name="email" value="admin@perpustakaan.com" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 text-sm font-semibold text-white bg-purple-600 border border-transparent rounded-xl hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors shadow-sm flex items-center justify-center gap-2">
                            Simpan Profil
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- KARTU 2: UBAH PASSWORD -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <form action="#" method="POST" class="flex flex-col h-full">
                @csrf
                <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-xl shrink-0">
                        <i class="ph ph-lock-key"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Ubah Kata Sandi</h2>
                        <p class="text-xs text-gray-500">Pastikan akun Anda menggunakan kata sandi yang kuat</p>
                    </div>
                </div>

                <div class="p-6 flex flex-col gap-5 flex-1">
                    <!-- Password Lama -->
                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi Saat Ini</label>
                        <input type="password" id="current_password" name="current_password" placeholder="••••••••" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                    </div>

                    <!-- Password Baru -->
                    <div>
                        <label for="new_password" class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi Baru</label>
                        <input type="password" id="new_password" name="new_password" placeholder="••••••••" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="••••••••" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition text-sm text-gray-800">
                    </div>

                    <!-- Spasi agar tombol turun ke bawah -->
                    <div class="mt-auto pt-4">
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 text-sm font-semibold text-white bg-gray-800 border border-transparent rounded-xl hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors shadow-sm flex items-center justify-center gap-2">
                            Perbarui Kata Sandi
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>

</x-admin-layout>
