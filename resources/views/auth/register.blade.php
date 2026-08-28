<x-guest-layout>
    <x-slot:title>
        Daftar Akun - Sistem Manajemen Perpustakaan
    </x-slot:title>

    <div class="w-full max-w-md bg-white p-8">
        <div class="mb-8 text-center md:text-left">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Daftar Akun</h1>
            <p class="text-gray-500 text-sm">Silakan lengkapi data di bawah ini untuk membuat akun baru.</p>
        </div>

        <form action="{{ route('register.process') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Input Nama Lengkap -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ph ph-user text-gray-400 text-xl"></i>
                    </div>
                    <input type="text" name="name" id="name" placeholder="Masukan Nama Lengkap"
                        class="pl-10 w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-blue-900 outline-none transition placeholder-gray-400 text-gray-700" required>
                </div>
            </div>

            <!-- Input Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ph ph-envelope-simple text-gray-400 text-xl"></i>
                    </div>
                    <input type="email" name="email" id="email" placeholder="Masukan Email Anda"
                        class="pl-10 w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-blue-900 outline-none transition placeholder-gray-400 text-gray-700" required>
                </div>
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ph ph-lock-key text-gray-400 text-xl"></i>
                    </div>
                    <input type="password" name="password" id="password" placeholder="Buat Password"
                        class="pl-10 pr-10 w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-blue-900 outline-none transition placeholder-gray-400 text-gray-700" required>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                        <i class="ph ph-eye text-gray-400 text-xl hover:text-gray-600 transition"></i>
                    </div>
                </div>
            </div>

            <!-- Input Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ph ph-lock-key text-gray-400 text-xl"></i>
                    </div>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ketik Ulang Password"
                        class="pl-10 pr-10 w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-blue-900 outline-none transition placeholder-gray-400 text-gray-700" required>
                </div>
            </div>

            <!-- Tombol Daftar -->
            <div class="pt-4">
                <button type="submit" class="w-full bg-[#004a8c] hover:bg-blue-900 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 ease-in-out shadow-sm">
                    Daftar Sekarang
                </button>
            </div>
        </form>

        <!-- Kembali ke Login -->
        <div class="mt-8 text-center text-sm text-gray-600">
            Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-[#004a8c] hover:text-blue-900 transition">Masuk di sini</a>
        </div>
    </div>
</x-guest-layout>
