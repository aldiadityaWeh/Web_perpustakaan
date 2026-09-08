<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Sandi Baru - Sistem Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4 font-sans text-gray-800">

    <div class="bg-white w-full max-w-md rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-8 sm:p-10 flex flex-col items-center">
            
            <div class="h-20 w-20 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center text-4xl mb-6 shadow-sm border border-blue-100">
                <i class="ph ph-shield-check"></i>
            </div>
            
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Buat Sandi Baru</h1>
            <p class="text-sm text-gray-500 text-center mb-8">
                Tautan valid! Silakan masukkan kata sandi baru untuk mengamankan kembali akun Anda.
            </p>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm flex gap-3 w-full">
                    <i class="ph ph-warning-circle text-xl shrink-0"></i>
                    <p>{{ $errors->first() }}</p>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="w-full flex flex-col gap-5">
                @csrf
                
                <!-- Token rahasia yang dibawa dari link email -->
                <input type="hidden" name="token" value="{{ $token }}">
                
                <!-- Email (readonly agar tidak bisa diubah orang lain) -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Email Akun Terdaftar</label>
                    <input type="email" name="email" value="{{ $email ?? old('email') }}" readonly class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-500 cursor-not-allowed outline-none text-center font-medium">
                </div>

                <!-- Input Password Baru (Dengan Alpine JS) -->
                <div x-data="{ show: false }">
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Kata Sandi Baru</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="ph ph-lock-key text-gray-400 text-lg"></i>
                        </div>
                        <input :type="show ? 'text' : 'password'" name="password" required placeholder="Minimal 3 - 8 Karakter" class="pl-11 pr-12 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                        
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-blue-600 focus:outline-none transition-colors">
                            <i class="text-lg" :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'"></i>
                        </button>
                    </div>
                    
                    <!-- Sistem bawaan Laravel membutuhkan input konfirmasi tersembunyi -->
                    <input type="hidden" name="password_confirmation" id="password_confirmation_hidden">
                </div>

                <!-- Saat diklik, JS akan otomatis menyalin password ke field konfirmasi tersembunyi -->
                <button type="submit" onclick="document.getElementById('password_confirmation_hidden').value = document.querySelector('input[name=password]').value" class="w-full mt-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition-colors shadow-md">
                    Simpan & Masuk
                </button>
            </form>

        </div>
    </div>

</body>
</html>