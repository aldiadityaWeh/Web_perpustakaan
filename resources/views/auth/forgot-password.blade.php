<x-guest-layout>
    <x-slot:title>
        Lupa Password - Sistem Manajemen Perpustakaan
    </x-slot:title>

    <div class="w-full max-w-md bg-white p-8">
        <div class="mb-6 text-center md:text-left">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Lupa Password?</h1>
            <p class="text-gray-500 text-sm leading-relaxed">
                Jangan khawatir! Masukkan alamat email yang terhubung dengan akun Anda, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi.
            </p>
        </div>

        <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Input Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ph ph-envelope-simple text-gray-400 text-xl"></i>
                    </div>
                    <input type="email" name="email" id="email" placeholder="Contoh: user@email.com"
                        class="pl-10 w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-blue-900 outline-none transition placeholder-gray-400 text-gray-700" required>
                </div>
            </div>

            <!-- Tombol Kirim -->
            <div class="pt-2">
                <button type="submit" class="w-full bg-[#004a8c] hover:bg-blue-900 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 ease-in-out shadow-sm flex justify-center items-center gap-2">
                    Kirim Tautan Reset
                    <i class="ph ph-paper-plane-right text-lg"></i>
                </button>
            </div>
        </form>

        <!-- Kembali ke Login -->
        <div class="mt-8 text-center text-sm text-gray-600">
            Ingat password Anda? <a href="{{ route('login') }}" class="font-bold text-[#004a8c] hover:text-blue-900 transition">Kembali ke halaman Masuk</a>
        </div>
    </div>
</x-guest-layout>
