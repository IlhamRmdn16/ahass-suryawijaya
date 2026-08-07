<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'AHASS' }} - Sistem Antrean Bengkel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-100 text-slate-800 antialiased">
    <div class="min-h-screen lg:flex" x-data="{ sidebarOpen: false }">

        {{-- ============================================= --}}
        {{-- SIDEBAR DESKTOP -- bagian normal dari layout, --}}
        {{-- selalu tampil, tidak pernah overlap ke konten --}}
        {{-- ============================================= --}}
        <aside class="hidden lg:flex lg:flex-col lg:w-64 lg:shrink-0 bg-slate-900 text-slate-300">
            @include('components.sidebar-nav')
        </aside>

        {{-- ============================================= --}}
        {{-- SIDEBAR MOBILE -- overlay terpisah, cuma dirender--}}
        {{-- saat dibuka. Sama sekali lepas dari flow desktop --}}
        {{-- ============================================= --}}
        <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-40 lg:hidden" role="dialog" aria-modal="true">
            <div x-show="sidebarOpen"
                 x-transition:enter="transition-opacity ease-linear duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 bg-slate-900/60"></div>

            <aside x-show="sidebarOpen"
                   x-transition:enter="transition ease-out duration-200"
                   x-transition:enter-start="-translate-x-full"
                   x-transition:enter-end="translate-x-0"
                   x-transition:leave="transition ease-in duration-150"
                   x-transition:leave-start="translate-x-0"
                   x-transition:leave-end="-translate-x-full"
                   class="relative flex flex-col w-64 h-full bg-slate-900 text-slate-300">
                @include('components.sidebar-nav')
            </aside>
        </div>

        {{-- ============================================= --}}
        {{-- KONTEN UTAMA --}}
        {{-- ============================================= --}}
        <div class="flex-1 min-w-0 flex flex-col">

            {{-- Top bar -- hanya tampil di mobile/tablet, isinya tombol buka sidebar --}}
            <header class="lg:hidden sticky top-0 z-20 h-16 bg-white border-b border-slate-200 flex items-center px-4">
                <button @click="sidebarOpen = true" class="text-slate-600 p-1 -ml-1" aria-label="Buka menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="flex items-center gap-2 ml-3">
                    <div class="w-7 h-7 rounded-md bg-red-600 flex items-center justify-center text-white font-bold text-xs">A</div>
                    <span class="font-semibold text-slate-800">AHASS</span>
                </div>
            </header>

            <main class="flex-1 w-full max-w-[1600px] mx-auto p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
