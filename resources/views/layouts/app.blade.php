<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'AHASS' }} - Sistem Antrean Bengkel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-100 text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex">

        {{-- Overlay untuk mobile --}}
        <div x-show="sidebarOpen"
             x-cloak
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-slate-900/50 z-30 lg:hidden"></div>

        {{-- Sidebar --}}
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-slate-300 flex flex-col transition-transform duration-200 lg:translate-x-0 lg:static">

            <div class="h-16 flex items-center gap-2 px-5 border-b border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-red-600 flex items-center justify-center text-white font-bold text-sm">A</div>
                <span class="text-white font-semibold text-lg">AHASS</span>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">

                <a href="{{ route('antrean.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                   {{ request()->routeIs('antrean.*') ? 'bg-slate-800 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Antrean
                </a>

                @can('view own antrean')
                <a href="{{ route('mekanik.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                   {{ request()->routeIs('mekanik.dashboard') ? 'bg-slate-800 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Tugas Saya
                </a>
                @endcan

                <a href="{{ route('monitor.board') }}" target="_blank"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition hover:bg-slate-800 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Monitor Board
                </a>

                @can('manage mekanik')
                <div class="pt-4 pb-1 px-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Master Data</div>
                <a href="{{ route('mekanik.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                   {{ request()->routeIs('mekanik.index') ? 'bg-slate-800 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.982 3.827a1 1 0 011.6.294l1.02 2.04 2.256.328a1 1 0 01.554 1.706l-1.632 1.591.385 2.247a1 1 0 01-1.451 1.054L16.68 12l-2.034 1.087a1 1 0 01-1.451-1.054l.385-2.247-1.632-1.591a1 1 0 01.554-1.706l2.256-.328zM6 14a3 3 0 100-6 3 3 0 000 6zm0 0c-2.21 0-6 1.343-6 4v1h9v-1c0-.653-.184-1.27-.5-1.816" />
                    </svg>
                    Data Mekanik
                </a>
                @endcan

                @can('manage jenis pekerjaan')
                <a href="{{ route('jenis-pekerjaan.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                   {{ request()->routeIs('jenis-pekerjaan.index') ? 'bg-slate-800 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Jenis Pekerjaan
                </a>
                @endcan

                @can('manage users')
                <a href="{{ route('users.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                   {{ request()->routeIs('users.index') ? 'bg-slate-800 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Pengguna & Role
                </a>
                @endcan

                @can('view laporan')
                <div class="pt-4 pb-1 px-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Laporan</div>
                <a href="{{ route('laporan.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                   {{ request()->routeIs('laporan.index') ? 'bg-slate-800 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17V9m4 8V5m4 12v-4M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Laporan
                </a>
                @endcan

            </nav>

            {{-- User info + logout --}}
            <div class="border-t border-slate-800 p-3">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-3 px-2 py-2 rounded-lg hover:bg-slate-800 transition">
                    <div class="w-9 h-9 rounded-full bg-slate-700 flex items-center justify-center text-white text-sm font-semibold shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ auth()->user()->getRoleNames()->first() ?? '-' }}</p>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Top bar (mobile only, buat toggle sidebar) --}}
            <header class="h-16 bg-white border-b border-slate-200 flex items-center px-4 lg:hidden">
                <button @click="sidebarOpen = true" class="text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <span class="ml-3 font-semibold text-slate-800">AHASS</span>
            </header>

            <main class="flex-1 p-4 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
