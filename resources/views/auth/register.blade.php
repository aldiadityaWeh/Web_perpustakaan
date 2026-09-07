<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sistem Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4 font-sans text-gray-800">

    <div class="bg-white w-full max-w-md rounded-3xl shadow-xl border border-gray-100 overflow-hidden my-8">
        <div class="p-8 sm:p-10">

            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Buat Akun Baru</h1>
                <p class="text-sm text-gray-500 mt-2">Daftar untuk mengelola perpustakaan</p>
            </div>

            <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-white border-2 border-gray-200 hover:bg-gray-50 rounded-xl text-sm font-bold text-gray-700 transition-colors mb-6">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                Daftar dengan Gmail
            </a>

            <div class="flex items-center gap-4 mb-6">
                <hr class="flex-1 border-gray-200">
                <span class="text-xs font-semibold text-gray-400 uppercase">Atau Daftar Manual</span>
                <hr class="flex-1 border-gray-200">
            </div>

            <form action="{{ route('register.process') }}" method="POST" class="flex flex-col gap-4">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Agung Prastiyo" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition text-sm">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" required placeholder="email@sekolah.com" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition text-sm">
                </div>

                <div x-data="{ show: false }">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kata Sandi</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" required placeholder="Minimal 8 karakter" class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition text-sm">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-purple-600 focus:outline-none transition-colors">
                            <i class="text-lg" :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'"></i>
                        </button>
                    </div>
                </div>

                <div x-data="{ show: false }">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Ulangi Kata Sandi</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password_confirmation" required placeholder="Ulangi sandi di atas" class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-600 outline-none transition text-sm">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-purple-600 focus:outline-none transition-colors">
                            <i class="text-lg" :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full mt-4 bg-gray-900 hover:bg-black text-white font-semibold py-3 rounded-xl transition-colors shadow-md">
                    Buat Akun Sekarang
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-8">
                Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-purple-600 hover:text-purple-700">Masuk disini</a>
            </p>
        </div>
    </div>

</body>
</html>
