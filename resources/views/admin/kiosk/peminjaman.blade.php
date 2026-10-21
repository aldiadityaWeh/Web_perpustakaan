<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosk - Masukkan NIS</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Alpine JS untuk Dark Mode Toggle -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { transition: background-color 0.3s ease, color 0.3s ease; }
        /* Hilangkan panah spinner bawaan input number */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body class="bg-purple-50 dark:bg-slate-950 flex items-center justify-center min-h-screen p-4 relative overflow-hidden transition-colors">

    <!-- Tombol Toggle Dark Mode Melayang -->
    <button @click="darkMode = !darkMode" class="absolute top-4 right-4 sm:top-8 sm:right-8 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white dark:bg-slate-800 shadow-md border border-gray-200 dark:border-slate-700 flex items-center justify-center text-gray-500 dark:text-slate-400 hover:text-purple-600 dark:hover:text-purple-400 transition-all focus:outline-none z-10 transform hover:scale-110">
        <i class="ph text-xl sm:text-2xl transition-all" :class="darkMode ? 'ph-sun-dim text-amber-400' : 'ph-moon-stars'"></i>
    </button>

    <!-- Hiasan Background Blur Ekstra -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-purple-500/20 dark:bg-purple-600/10 blur-3xl rounded-full pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-blue-500/20 dark:bg-blue-600/10 blur-3xl rounded-full pointer-events-none"></div>

    <!-- Container Utama (Padding & Spacing diperkecil agar tinggi kotak ramping) -->
    <div class="w-full max-w-md bg-white dark:bg-slate-800 rounded-3xl shadow-2xl overflow-hidden border border-gray-100 dark:border-slate-700 relative z-10 transition-colors flex flex-col">

        <!-- Header Gradient -->
        <div class="bg-gradient-to-br from-purple-600 to-indigo-700 p-6 sm:p-8 text-center relative overflow-hidden shrink-0">
            <!-- Hiasan Geometris di Dalam Header -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-black/10 rounded-full blur-2xl"></div>

            <div class="relative z-10">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3 backdrop-blur-md border border-white/30 shadow-inner">
                    <i class="ph ph-identification-badge text-2xl sm:text-3xl text-white"></i>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-white mb-1 tracking-tight">Halo, Siswa!</h1>
                <p class="text-purple-100 text-xs sm:text-sm font-medium">Ketik NIS atau Sandi Kiosk Anda</p>
            </div>
        </div>

        <!-- Area Form -->
        <div class="p-6">
            <!-- Notifikasi Sukses / Gagal -->
            @if(session('success'))
                <div class="mb-4 p-3 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-800 dark:text-emerald-400 rounded-xl flex items-start gap-2 shadow-sm transition-colors">
                    <i class="ph ph-check-circle text-xl text-emerald-600 dark:text-emerald-400 shrink-0 mt-0.5"></i>
                    <div>
                        <h4 class="font-bold text-xs sm:text-sm">Aksi Berhasil!</h4>
                        <p class="text-[11px] sm:text-xs mt-0.5 leading-relaxed">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-3 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 rounded-xl flex items-start gap-2 transition-colors">
                    <i class="ph ph-warning-circle text-xl shrink-0"></i>
                    <p class="text-xs sm:text-sm font-medium mt-0.5">{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('kiosk.auth') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 dark:text-slate-300 mb-1.5 ml-1 transition-colors">Nomor Induk Siswa (NIS)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="ph ph-numpad text-gray-400 dark:text-slate-500 text-xl transition-colors"></i>
                        </div>
                        <input type="number" name="nis" required autofocus autocomplete="off" placeholder="Ketik NIS Anda..."
                            class="pl-11 w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-2xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-purple-600/50 focus:border-purple-600 outline-none transition-all text-base sm:text-lg font-bold text-gray-800 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 tracking-wider shadow-sm">
                    </div>
                </div>

                <button type="submit" class="w-full bg-gray-900 dark:bg-purple-600 hover:bg-black dark:hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-2xl transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2 text-sm sm:text-base transform hover:-translate-y-0.5">
                    Mulai Pilih Buku <i class="ph ph-arrow-right font-bold text-lg"></i>
                </button>
            </form>
        </div>

        <!-- Footer Info -->
        <div class="bg-gray-50 dark:bg-slate-800/50 px-6 py-4 text-center border-t border-gray-100 dark:border-slate-700 transition-colors shrink-0">
            <a href="{{ route('peminjaman.index') }}" class="text-[11px] sm:text-xs font-bold text-gray-400 dark:text-slate-500 hover:text-purple-600 dark:hover:text-purple-400 transition-colors uppercase tracking-wider flex items-center justify-center gap-1.5 inline-flex">
                <i class="ph ph-arrow-left text-sm"></i> Kembali ke Dasbor Admin
            </a>
        </div>
    </div>

</body>
</html>
