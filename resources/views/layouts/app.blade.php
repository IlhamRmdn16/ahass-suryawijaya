<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'AHASS' }} - Sistem Antrean Bengkel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-50 text-slate-800 antialiased h-screen overflow-hidden" x-data="{ sidebarOpen: true }">

    <div class="h-full">

        {{-- Overlay -- cuma muncul di mobile saat sidebar terbuka --}}
        <div x-show="sidebarOpen"
             x-cloak
             x-transition.opacity
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-30 lg:hidden"></div>

        {{-- Sidebar -- SELALU fixed (di mobile & desktop) supaya diam saat konten discroll.
             mobile: slide in/out penuh. desktop: collapse jadi mini-icon (80px). --}}
        <aside
            :class="sidebarOpen ? 'translate-x-0 w-72' : '-translate-x-full lg:translate-x-0 w-72 lg:w-20'"
            class="fixed inset-y-0 left-0 z-40 overflow-hidden
                transition-all duration-300 ease-in-out shadow-2xl lg:shadow-none
                border-r-2 border-red-600">
            <div class="h-full w-full flex flex-col bg-white">
                @include('components.sidebar-nav')
            </div>
        </aside>

        {{-- Konten utama -- diberi margin-left sebesar lebar sidebar (desktop),
             supaya tidak ketiban sidebar yang sekarang fixed --}}
        <div :class="sidebarOpen ? 'lg:ml-72' : 'lg:ml-20'"
             class="h-full flex flex-col min-w-0 transition-all duration-300 ease-in-out">

            {{-- Top bar -- tombol toggle di sini cuma buat mobile --}}
            <header class="h-16 bg-white/90 backdrop-blur border-b border-slate-200 flex items-center justify-between px-4 lg:px-6 shrink-0 z-20">
                <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <span class="font-semibold text-slate-800 tracking-tight truncate">{{ $title ?? 'AHASS Surya Wijaya' }}</span>
                <span class="w-9 lg:hidden"></span>
            </header>

            {{-- Hanya area ini yang scroll --}}
            <main class="flex-1 overflow-y-auto p-4 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>