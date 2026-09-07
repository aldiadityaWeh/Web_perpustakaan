<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - Sistem Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4 font-sans text-gray-800">

    <div class="bg-white w-full max-w-md rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-8 sm:p-10 flex flex-col items-center">

            <div class="h-20 w-20 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center text-4xl mb-6">
                <i class="ph ph-key"></i>
            </div>

            <h1 class="text-2xl font-bold text-gray-900 mb-2">Lupa Kata Sandi?</h1>
            <p class="text-sm text-gray-500 text-center mb-8">
                Jangan khawatir. Masukkan alamat email yang terdaftar, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
            </p>

            <form action="#" method="POST" class="w-full flex flex-col gap-4">
                @csrf
                <div>
                    <input type="email" name="email" required placeholder="Masukkan email Anda" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none transition text-sm text-center">
                </div>

                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3 rounded-xl transition-colors shadow-md">
                    Kirim Tautan Reset
                </button>
            </form>

            <a href="{{ route('login') }}" class="mt-8 flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">
                <i class="ph ph-arrow-left text-lg"></i>
                Kembali ke Halaman Login
            </a>
        </div>
    </div>

</body>
</html>
