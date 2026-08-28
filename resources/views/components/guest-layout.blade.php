<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Masuk - Perpustakaan' }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Phosphor Icons CDN for icons inside inputs (email, lock, eye) -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-white font-sans text-gray-800 antialiased min-h-screen flex flex-col">
    <!-- Header Logo Area -->
    <header class="p-6">
        <div class="flex items-center gap-4">
            <!-- Ganti dengan path logo asli Anda nantinya -->
            <div class="h-12 w-12 rounded-full border-2 border-blue-900 flex items-center justify-center text-blue-900 font-bold text-xs">
                LOGO
            </div>
            <div class="flex flex-col">
                <span class="text-blue-900 font-extrabold text-2xl tracking-tighter leading-none">SDN6</span>
                <span class="text-blue-900 font-semibold text-sm leading-none mt-1">CISEUREH<br>PURWAKARTA</span>
            </div>
        </div>
    </header>

    <!-- Main Content Area with Slot for Guest -->
    <main class="flex-grow flex items-center justify-center p-6">
        {{ $slot }}
    </main>
</body>
</html>
