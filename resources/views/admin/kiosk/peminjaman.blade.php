<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosk - Masukkan NIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-purple-50 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">

        <div class="bg-gradient-to-br from-purple-600 to-indigo-700 p-10 text-center relative overflow-hidden">
            <!-- Hiasan Background -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-black/10 rounded-full blur-2xl"></div>

            <div class="relative z-10">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-5 backdrop-blur-md border border-white/30 shadow-inner">
                    <i class="ph ph-identification-badge text-4xl text-white"></i>
                </div>
                <h1 class="text-3xl font-extrabold text-white mb-2 tracking-tight">Halo, Siswa!</h1>
                <p class="text-purple-100 text-sm font-medium">Scan Kartu Pelajar atau Ketik NIS Anda untuk mulai meminjam buku</p>
            </div>
        </div>

        <div class="p-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-start gap-3 shadow-sm">
                    <i class="ph ph-check-circle text-2xl text-emerald-600 mt-0.5"></i>
                    <div>
                        <h4 class="font-bold text-sm">Peminjaman Sukses!</h4>
                        <p class="text-xs mt-1 leading-relaxed">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-start gap-3">
                    <i class="ph ph-warning-circle text-2xl"></i>
                    <p class="text-sm font-medium mt-0.5">{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('kiosk.auth') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Nomor Induk Siswa (NIS)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                            <i class="ph ph-scan text-gray-400 text-xl"></i>
                        </div>
                        <input type="number" name="nis" required autofocus autocomplete="off" placeholder="Contoh: 1000000001"
                            class="pl-13 w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-purple-600/20 focus:border-purple-600 outline-none transition-all text-lg font-bold text-gray-800 placeholder-gray-300">
                    </div>
                </div>

                <button type="submit" class="w-full bg-gray-900 hover:bg-black text-white font-bold py-4 px-4 rounded-2xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2 text-lg transform hover:-translate-y-0.5">
                    Mulai Pilih Buku <i class="ph ph-arrow-right font-bold"></i>
                </button>
            </form>
        </div>

        <div class="bg-gray-50 px-8 py-5 text-center">
            <a href="{{ route('peminjaman.index') }}" class="text-xs font-bold text-gray-400 hover:text-gray-600 transition-colors uppercase tracking-wider">
                &larr; Dasbor Admin
            </a>
        </div>
    </div>

</body>
</html>
