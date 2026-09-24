<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Sistem Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4 font-sans text-gray-800">

    <div class="bg-white w-full max-w-md rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-8 sm:p-10">

           <div class="text-center mb-8">
                <div class="h-20 w-20 mx-auto mb-4 bg-white rounded-2xl p-1 shadow-sm border border-gray-100 overflow-hidden flex items-center justify-center">
                    <img src="{{ asset('images/sd.png') }}" alt="Logo Sekolah" class="w-full h-full object-contain">
                </div>

                <h1 class="text-2xl font-bold text-gray-900">Sistem Perpustakaan </h1>
                <p class="text-sm text-gray-500 mt-2">Harap masukkan terlebih dahulu</p>
            </div>

            <!-- TAMBAHKAN BLOK INI UNTUK MENAMPILKAN PESAN SUKSES DARI REGISTER -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-sm flex gap-3 shadow-sm">
                    <i class="ph ph-check-circle text-xl shrink-0"></i>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm flex gap-3">
                    <i class="ph ph-warning-circle text-xl shrink-0"></i>
                    <p>{{ $errors->first() }}</p>
                </div>
            @endif

            <!-- Form Login Manual Murni -->
            <form action="{{ route('login.process') }}" method="POST" class="flex flex-col gap-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="ph ph-envelope-simple text-gray-400 text-lg"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="Email.com" class="pl-11 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition text-sm">
                    </div>
                </div>

                <div x-data="{ show: false }">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-semibold text-gray-700">Kata Sandi</label>
                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-purple-600 hover:text-purple-700">Lupa sandi?</a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="ph ph-lock-key text-gray-400 text-lg"></i>
                        </div>
                        <input :type="show ? 'text' : 'password'" name="password" class="pl-11 pr-12 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition text-sm">

                        <!-- Tombol Mata (Fitur Alpine.js) -->
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-purple-600 focus:outline-none transition-colors">
                            <i class="text-lg" :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full mt-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-xl transition-colors shadow-md shadow-purple-200">
                    Masuk
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-8">
                Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-purple-600 hover:text-purple-700">Gas bikin</a>
            </p>
        </div>
    </div>

</body>
</html>
