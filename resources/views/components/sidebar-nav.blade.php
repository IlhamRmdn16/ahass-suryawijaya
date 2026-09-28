<div class="shrink-0 border-b border-red-100 flex items-center gap-2.5 px-4 py-4"
     :class="sidebarOpen ? 'justify-between' : 'lg:flex-col lg:gap-3 lg:px-2'">

    <div class="flex items-center gap-2.5 min-w-0" :class="sidebarOpen ? '' : 'lg:justify-center'">
        <img src="{{ asset('images/ahass.webp') }}" alt="AHASS" class="h-9 w-auto shrink-0 rounded-md ring-1 ring-slate-200">
        <div x-show="sidebarOpen" x-transition.opacity class="leading-tight truncate">
            <p class="text-slate-900 font-bold text-sm tracking-wide">AHASS</p>
            <p class="text-red-600 text-[11px] font-medium tracking-[0.15em]">SURYA WIJAYA</p>
        </div>
    </div>

    {{-- Tombol toggle -- ada DI DALAM sidebar, pojok kanan atas.
         Panah berputar arah sesuai status buka/tutup. --}}
    <button @click="sidebarOpen = !sidebarOpen"
        class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition shrink-0">
        <svg :class="sidebarOpen ? '' : 'rotate-180'" class="w-4 h-4 transition-transform duration-300"
             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
    </button>
</div>

<nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto overflow-x-hidden">

    @if (! auth()->user()->hasRole('mekanik'))
    <a href="{{ route('antrean.index') }}"
       :class="sidebarOpen ? '' : 'lg:justify-center lg:px-0'"
       :title="sidebarOpen ? '' : 'Antrean'"
       @class([
           'group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all',
           'bg-gradient-to-r from-red-600 to-red-500 text-white shadow-lg shadow-red-500/30' => request()->routeIs('antrean.*'),
           'text-slate-600 hover:text-red-700 hover:bg-red-50' => ! request()->routeIs('antrean.*'),
       ])>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Antrean</span>
    </a>
    @endif

    @if (auth()->user()->hasRole('mekanik'))
    <a href="{{ route('mekanik.dashboard') }}"
       :class="sidebarOpen ? '' : 'lg:justify-center lg:px-0'"
       :title="sidebarOpen ? '' : 'Tugas Saya'"
       @class([
           'group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all',
           'bg-gradient-to-r from-red-600 to-red-500 text-white shadow-lg shadow-red-500/30' => request()->routeIs('mekanik.dashboard'),
           'text-slate-600 hover:text-red-700 hover:bg-red-50' => ! request()->routeIs('mekanik.dashboard'),
       ])>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Tugas Saya</span>
    </a>
    @endif

    @can('buat pkb')
    <a href="{{ route('pkb.index') }}"
       :class="sidebarOpen ? '' : 'lg:justify-center lg:px-0'"
       :title="sidebarOpen ? '' : 'PKB'"
       @class([
           'group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all',
           'bg-gradient-to-r from-red-600 to-red-500 text-white shadow-lg shadow-red-500/30' => request()->routeIs('pkb.*'),
           'text-slate-600 hover:text-red-700 hover:bg-red-50' => ! request()->routeIs('pkb.*'),
       ])>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span x-show="sidebarOpen" x-transition.opacity class="truncate">PKB</span>
    </a>
    @endcan

    <a href="{{ route('monitor.board') }}" target="_blank"
       :class="sidebarOpen ? '' : 'lg:justify-center lg:px-0'"
       :title="sidebarOpen ? '' : 'Monitor Board'"
       class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:text-red-700 hover:bg-red-50 transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Monitor Board</span>
    </a>

    @can('manage mekanik')
    <div x-show="sidebarOpen" x-transition.opacity class="pt-5 pb-2 px-3 flex items-center gap-2">
        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest whitespace-nowrap">Master Data</span>
        <span class="flex-1 h-px bg-gradient-to-r from-red-200 to-transparent"></span>
    </div>
    <div x-show="! sidebarOpen" class="hidden lg:block pt-4"></div>
    <a href="{{ route('mekanik.index') }}"
       :class="sidebarOpen ? '' : 'lg:justify-center lg:px-0'"
       :title="sidebarOpen ? '' : 'Data Mekanik'"
       @class([
           'group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all',
           'bg-gradient-to-r from-red-600 to-red-500 text-white shadow-lg shadow-red-500/30' => request()->routeIs('mekanik.index'),
           'text-slate-600 hover:text-red-700 hover:bg-red-50' => ! request()->routeIs('mekanik.index'),
       ])>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.982 3.827a1 1 0 011.6.294l1.02 2.04 2.256.328a1 1 0 01.554 1.706l-1.632 1.591.385 2.247a1 1 0 01-1.451 1.054L16.68 12l-2.034 1.087a1 1 0 01-1.451-1.054l.385-2.247-1.632-1.591a1 1 0 01.554-1.706l2.256-.328zM6 14a3 3 0 100-6 3 3 0 000 6zm0 0c-2.21 0-6 1.343-6 4v1h9v-1c0-.653-.184-1.27-.5-1.816" />
        </svg>
        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Data Mekanik</span>
    </a>
    @endcan

    @can('manage jenis pekerjaan')
    <a href="{{ route('jenis-pekerjaan.index') }}"
       :class="sidebarOpen ? '' : 'lg:justify-center lg:px-0'"
       :title="sidebarOpen ? '' : 'Jenis Pekerjaan'"
       @class([
           'group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all',
           'bg-gradient-to-r from-red-600 to-red-500 text-white shadow-lg shadow-red-500/30' => request()->routeIs('jenis-pekerjaan.index'),
           'text-slate-600 hover:text-red-700 hover:bg-red-50' => ! request()->routeIs('jenis-pekerjaan.index'),
       ])>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Jenis Pekerjaan</span>
    </a>
    @endcan

    @can('manage users')
    <a href="{{ route('users.index') }}"
       :class="sidebarOpen ? '' : 'lg:justify-center lg:px-0'"
       :title="sidebarOpen ? '' : 'Pengguna & Role'"
       @class([
           'group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all',
           'bg-gradient-to-r from-red-600 to-red-500 text-white shadow-lg shadow-red-500/30' => request()->routeIs('users.index'),
           'text-slate-600 hover:text-red-700 hover:bg-red-50' => ! request()->routeIs('users.index'),
       ])>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Pengguna & Role</span>
    </a>
    @endcan

    @can('view laporan')
    <div x-show="sidebarOpen" x-transition.opacity class="pt-5 pb-2 px-3 flex items-center gap-2">
        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest whitespace-nowrap">Laporan</span>
        <span class="flex-1 h-px bg-gradient-to-r from-red-200 to-transparent"></span>
    </div>
    <div x-show="! sidebarOpen" class="hidden lg:block pt-4"></div>
    <a href="{{ route('laporan.index') }}"
       :class="sidebarOpen ? '' : 'lg:justify-center lg:px-0'"
       :title="sidebarOpen ? '' : 'Laporan'"
       @class([
           'group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all',
           'bg-gradient-to-r from-red-600 to-red-500 text-white shadow-lg shadow-red-500/30' => request()->routeIs('laporan.index'),
           'text-slate-600 hover:text-red-700 hover:bg-red-50' => ! request()->routeIs('laporan.index'),
       ])>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17V9m4 8V5m4 12v-4M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
        </svg>
        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Laporan</span>
    </a>
    @endcan

</nav>
