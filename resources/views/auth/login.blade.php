<x-guest-layout>
    <x-slot:title>
        Masuk - Sistem Manajemen Perpustakaan
    </x-slot:title>

    <div class="w-full max-w-md bg-white p-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Masuk</h1>
            <p class="text-gray-500 text-sm">Selamat datang di Sistem Perpustakaan Sekolah</p>
        </div>

        <!-- Update Action Form menggunakan Route Name -->
        <form action="{{ route('login.process') }}" method="POST" class="space-y-5">
            @csrf

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
                    <input type="password" name="password" id="password" placeholder="Masukan Password Anda"
                        class="pl-10 pr-10 w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-blue-900 outline-none transition placeholder-gray-400 text-gray-700" required>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                        <i class="ph ph-eye text-gray-400 text-xl hover:text-gray-600 transition"></i>
                    </div>
                </div>
            </div>

            <!-- Lupa Password Update link -->
            <div class="flex justify-end">
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-red-500 hover:text-red-700 transition">Lupa Password</a>
            </div>

            <!-- Tombol Masuk -->
            <div class="pt-2">
                <button type="submit" class="w-full bg-[#004a8c] hover:bg-blue-900 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 ease-in-out shadow-sm">
                    Masuk
                </button>
            </div>
        </form>

        <!-- Daftar Update link -->
        <div class="mt-8 text-center text-sm text-gray-600">
            Don't have an account? <a href="{{ route('register') }}" class="font-bold text-green-700 hover:text-green-800 transition">Daftar</a>
        </div>
    </div>
</x-guest-layout>
