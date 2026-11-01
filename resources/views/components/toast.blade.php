<!-- resources/views/components/toast.blade.php -->
<div class="fixed top-5 right-5 z-[9999] flex flex-col gap-3 pointer-events-none">
    
    <!-- Pop-up Sukses -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-x-10"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="bg-white border-l-4 border-emerald-500 shadow-xl rounded-xl px-5 py-4 flex items-center gap-3 w-80 pointer-events-auto">
            
            <i class="ph-fill ph-check-circle text-2xl text-emerald-500 shrink-0"></i>
            <p class="text-sm font-medium text-gray-700 w-full">{{ session('success') }}</p>
            
            <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition">
                <i class="ph ph-x text-lg"></i>
            </button>
        </div>
    @endif

    <!-- Pop-up Error -->
    @if(session('error') || $errors->any())
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-x-10"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="bg-white border-l-4 border-red-500 shadow-xl rounded-xl px-5 py-4 flex items-center gap-3 w-80 pointer-events-auto">
            
            <i class="ph-fill ph-warning-circle text-2xl text-red-500 shrink-0"></i>
            <p class="text-sm font-medium text-gray-700 w-full">
                {{ session('error') ?? $errors->first() }}
            </p>
            
            <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition">
                <i class="ph ph-x text-lg"></i>
            </button>
        </div>
    @endif

</div>