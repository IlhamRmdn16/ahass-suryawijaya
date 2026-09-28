<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'AHASS' }} - Sistem Antrean Bengkel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-50 text-slate-800 antialiased"
      x-data="{ sidebarOpen: true, userMenu: false, logoutConfirm: false }"
      @keydown.escape.window="userMenu = false; logoutConfirm = false">

    <div class="min-h-screen flex">

        {{-- Overlay sidebar -- cuma muncul di mobile saat sidebar terbuka --}}
        <div x-show="sidebarOpen"
             x-cloak
             x-transition.opacity
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-30 lg:hidden"></div>

        {{-- Sidebar -- mobile: slide in/out penuh (fixed). desktop: sticky setinggi
             layar sehingga TIDAK ikut ter-scroll, collapse jadi mini-icon (80px) --}}
        <aside
            :class="sidebarOpen ? 'translate-x-0 lg:w-72' : '-translate-x-full lg:translate-x-0 lg:w-20'"
            class="fixed inset-y-0 left-0 z-40 w-72 shrink-0 overflow-hidden
                   lg:sticky lg:top-0 lg:bottom-auto lg:h-screen lg:self-start
                   transition-all duration-300 ease-in-out shadow-2xl lg:shadow-none">
            <div class="h-full flex flex-col bg-white border-r-2 border-red-600 shadow-[4px_0_24px_-8px_rgba(220,38,38,0.25)]"
                 :class="sidebarOpen ? 'w-72' : 'w-72 lg:w-20'">
                @include('components.sidebar-nav')
            </div>
        </aside>

        {{-- Konten utama --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Top bar --}}
            <header class="h-16 bg-white/90 backdrop-blur border-b border-slate-200 flex items-center justify-between px-4 lg:px-6 sticky top-0 z-20">

                {{-- Kiri: tombol buka sidebar (mobile) + judul --}}
                <div class="flex items-center gap-3 min-w-0">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <span class="font-semibold text-slate-800 tracking-tight truncate">{{ $title ?? 'AHASS Surya Wijaya' }}</span>
                </div>

                {{-- Kanan: foto profil + nama, klik untuk buka dropdown --}}
                <div class="relative shrink-0">
                    <button type="button" @click="userMenu = !userMenu"
                        class="flex items-center gap-2.5 pl-1.5 pr-3 py-1.5 rounded-full hover:bg-slate-100 transition"
                        :class="userMenu ? 'bg-slate-100' : ''">
                        @if (auth()->user()->foto_url)
                            <img src="{{ auth()->user()->foto_url }}" alt="Foto profil"
                                 class="w-8 h-8 rounded-full object-cover ring-2 ring-white shadow">
                        @else
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-red-600 to-red-800 flex items-center justify-center text-white text-sm font-semibold ring-2 ring-white shadow">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="hidden sm:block text-sm font-medium text-slate-700 max-w-[140px] truncate">
                            {{ auth()->user()->name }}
                        </span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform" :class="userMenu ? 'rotate-180' : ''"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    {{-- Dropdown --}}
                    <div x-show="userMenu"
                         x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         @click.outside="userMenu = false"
                         class="absolute right-0 mt-2 w-64 origin-top-right bg-white rounded-2xl shadow-xl ring-1 ring-slate-200 overflow-hidden z-50">

                        <div class="px-4 py-3.5 bg-slate-50 border-b border-slate-100">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                            <span class="inline-block mt-2 px-2 py-0.5 rounded-full bg-red-50 text-red-700 text-[10px] font-semibold uppercase tracking-wide">
                                {{ auth()->user()->getRoleNames()->first() ?? '-' }}
                            </span>
                        </div>

                        <div class="p-1.5">
                            <a href="{{ route('profile.edit') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-slate-700 hover:bg-slate-100 transition">
                                <svg class="w-[18px] h-[18px] text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                Profil Saya
                            </a>

                            <button type="button" @click="userMenu = false; logoutConfirm = true"
                                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-red-600 hover:bg-red-50 transition">
                                <svg class="w-[18px] h-[18px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                                Keluar
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- Form logout tersembunyi -- di-submit dari tombol konfirmasi di modal --}}
    <form method="POST" action="{{ route('logout') }}" x-ref="logoutForm" class="hidden">
        @csrf
    </form>

    {{-- Modal konfirmasi keluar -- sengaja di level body (bukan di dalam header)
         karena header punya backdrop-blur yang bikin elemen fixed di dalamnya
         ke-jebak di ukuran header. --}}
    <div x-show="logoutConfirm"
         x-cloak
         class="fixed inset-0 z-[60] flex items-center justify-center px-4">

        <div x-show="logoutConfirm"
             x-transition.opacity
             @click="logoutConfirm = false"
             class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm"></div>

        <div x-show="logoutConfirm"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">

            <div class="mx-auto w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
            </div>

            <h3 class="text-lg font-semibold text-slate-800">Yakin ingin keluar?</h3>
            <p class="text-sm text-slate-500 mt-1">Kamu akan keluar dari akun <strong class="text-slate-700">{{ auth()->user()->name }}</strong>.</p>

            <div class="flex gap-3 mt-6">
                <button type="button" @click="logoutConfirm = false"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                    Batal
                </button>
                <button type="button" @click="$refs.logoutForm.submit()"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 shadow-lg shadow-red-500/30 transition">
                    Ya, Keluar
                </button>
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
