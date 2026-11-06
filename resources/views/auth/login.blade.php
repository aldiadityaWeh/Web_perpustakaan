<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Sistem Perpustakaan SDN 6 Ciseureuh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="flex items-center justify-center min-h-screen p-4 font-sans text-gray-800 bg-cover bg-center bg-no-repeat relative overflow-hidden" style="background-image: url('{{ asset('images/anak-anak.jpg') }}');">

    <!-- Overlay semi-transparan -->
    <div class="absolute inset-0 bg-blue-900/40 backdrop-blur-sm z-0"></div>

    <!-- POP-UP TOAST NOTIFICATION -->
    <div class="fixed top-5 right-5 z-50 flex flex-col gap-3">
        <!-- Pop-up Sukses -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 translate-x-8"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="bg-white border-l-4 border-emerald-500 shadow-xl rounded-xl px-5 py-3 flex items-center gap-3 w-80">
                <i class="ph-fill ph-check-circle text-2xl text-emerald-500 shrink-0"></i>
                <p class="text-sm font-medium text-gray-700 w-full">{{ session('success') }}</p>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="ph ph-x text-lg"></i>
                </button>
            </div>
        @endif

        <!-- Pop-up Error -->
        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 translate-x-8"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="bg-white border-l-4 border-red-500 shadow-xl rounded-xl px-5 py-3 flex items-center gap-3 w-80">
                <i class="ph-fill ph-warning-circle text-2xl text-red-500 shrink-0"></i>
                <p class="text-sm font-medium text-gray-700 w-full">{{ $errors->first() }}</p>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="ph ph-x text-lg"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- KOTAK FORM LOGIN -->
    <div class="w-full max-w-[400px] rounded-3xl shadow-2xl border border-white/20 overflow-hidden relative z-10 bg-white/95 backdrop-blur-md">
        <div class="p-6 sm:p-8">

           <div class="text-center mb-5">
                <div class="h-16 w-16 mx-auto mb-3 bg-white rounded-2xl p-1.5 shadow-md border border-gray-100 overflow-hidden flex items-center justify-center">
                    <img src="{{ asset('images/sd.png') }}" alt="Logo SDN 6 Ciseureuh" class="w-full h-full object-contain">
                </div>
                <h1 class="text-xl font-black text-gray-900 tracking-tight">Perpustakaan Digital</h1>
                <p class="text-xs font-bold text-blue-600 mt-1">SDN 6 Ciseureuh Purwakarta</p>
            </div>

            <!-- Form Login (Gap dirapatkan agar tinggi total sama) -->
            <form action="{{ route('login.process') }}" method="POST" class="flex flex-col gap-3.5">
                @csrf

                <!-- PILIHAN ROLE (ADMIN / PETUGAS) -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Masuk Sebagai</label>
                    <div class="grid grid-cols-2 gap-1 p-1 bg-gray-100/80 rounded-xl border border-gray-200 relative">
                        <!-- Pilihan Admin -->
                        <label class="cursor-pointer relative text-center">
                            <input type="radio" name="role" value="admin" class="peer sr-only" required>
                            <div class="py-1.5 text-xs font-bold text-gray-500 rounded-lg peer-checked:bg-white peer-checked:text-blue-600 peer-checked:shadow-sm transition-all flex items-center justify-center gap-1.5">
                                <i class="ph-fill ph-shield-check text-sm"></i> Admin
                            </div>
                        </label>
                        <!-- Pilihan Petugas -->
                        <label class="cursor-pointer relative text-center">
                            <input type="radio" name="role" value="petugas" class="peer sr-only" checked required>
                            <div class="py-1.5 text-xs font-bold text-gray-500 rounded-lg peer-checked:bg-white peer-checked:text-emerald-600 peer-checked:shadow-sm transition-all flex items-center justify-center gap-1.5">
                                <i class="ph-fill ph-user text-sm"></i> Petugas
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Alamat Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none transition-colors group-focus-within:text-blue-600">
                            <i class="ph ph-envelope-simple text-gray-400 group-focus-within:text-blue-600 text-lg transition-colors"></i>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            autocomplete="username"
                            readonly onfocus="this.removeAttribute('readonly'); document.getElementById('password').removeAttribute('readonly');"
                            required placeholder="Email"
                            class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm bg-gray-50 focus:bg-white">
                    </div>
                </div>

                <div x-data="{ show: false }">
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Kata Sandi</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none transition-colors group-focus-within:text-blue-600">
                            <i class="ph ph-lock-key text-gray-400 group-focus-within:text-blue-600 text-lg transition-colors"></i>
                        </div>
                        <input :type="show ? 'text' : 'password'" name="password" id="password"
                            autocomplete="current-password"
                            readonly onfocus="this.removeAttribute('readonly'); document.getElementById('email').removeAttribute('readonly');"
                            required placeholder="Password"
                            class="pl-10 pr-10 w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm bg-gray-50 focus:bg-white">

                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-blue-600 focus:outline-none transition-colors">
                            <i class="text-lg transition-all" :class="show ? 'ph ph-eye-slash' : 'ph ph-eye'"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full mt-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-bold py-2.5 rounded-xl transition-all shadow-md shadow-blue-200 flex items-center justify-center gap-2 text-sm">
                    Masuk
                </button>
            </form>

            <p class="text-center text-[11px] text-gray-500 mt-5 font-semibold">
                &copy; {{ date('Y') }} UPTD SDN 6 Ciseureuh
            </p>

        </div>
    </div>

</body>
</html>
