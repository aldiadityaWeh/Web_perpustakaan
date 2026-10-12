<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sekolah - Sistem Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-lg bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 my-8">
        <!-- Header -->
        <div class="bg-purple-600 p-8 text-center">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                <i class="ph ph-buildings text-3xl text-white"></i>
            </div>
            <h1 class="text-2xl font-bold text-white mb-1">Daftarkan Sekolah</h1>
            <p class="text-purple-100 text-sm">Buat akun untuk mengelola perpustakaan Anda sendiri</p>
        </div>

        <div class="p-8">
            <!-- Alert Error -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-start gap-3">
                    <i class="ph ph-warning-circle text-2xl"></i>
                    <div>
                        <h4 class="font-bold text-sm">Pendaftaran Gagal</h4>
                        <p class="text-sm mt-0.5">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('register.process') }}" method="POST" class="space-y-5">
                @csrf
                
                <!-- Input Nama Sekolah -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Sekolah / Instansi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="ph ph-graduation-cap text-gray-400 text-lg"></i>
                        </div>
                        <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah') }}" required autofocus placeholder="Contoh: SDN 6 Ciseureuh"
                            class="pl-11 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition">
                    </div>
                </div>

                <hr class="border-gray-100 my-2">

                <!-- Input Nama Admin -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Admin / Pustakawan</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="ph ph-user text-gray-400 text-lg"></i>
                        </div>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama Lengkap Anda"
                            class="pl-11 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition">
                    </div>
                </div>

                <!-- Input Email -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="ph ph-envelope-simple text-gray-400 text-lg"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="admin@sekolah.com"
                            class="pl-11 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Input Password -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ph ph-lock-key text-gray-400 text-lg"></i>
                            </div>
                            <input type="password" name="password" required placeholder="Minimal 6 Karakter"
                                class="pl-11 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition">
                        </div>
                    </div>

                    <!-- Ulangi Password -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Ulangi Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="ph ph-lock-key-fill text-gray-400 text-lg"></i>
                            </div>
                            <input type="password" name="password_confirmation" required placeholder="Ketik ulang sandi"
                                class="pl-11 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-600 focus:border-purple-600 outline-none transition">
                        </div>
                    </div>
                </div>

                <!-- Tombol Daftar -->
                <button type="submit" class="w-full mt-4 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-sm flex items-center justify-center gap-2 text-lg">
                    Buat Akun Sekolah <i class="ph ph-arrow-right font-bold"></i>
                </button>
            </form>
            
            <p class="text-center text-sm mt-6 text-gray-500">
                Sudah mendaftarkan sekolah Anda? <br class="sm:hidden">
                <a href="{{ route('login') }}" class="font-bold text-purple-600 hover:text-purple-700">Masuk di sini</a>
            </p>
        </div>
        
    </div>

</body>
</html>