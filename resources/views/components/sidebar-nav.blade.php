{{-- =========================================================
    SIDEBAR AHASS - SURYA WIJAYA
    Tema: Premium Navy + White + AHASS Red
========================================================= --}}

<aside class="w-64 h-screen bg-[#0f172a] text-slate-300 flex flex-col border-r border-slate-700/60 shadow-2xl">

    {{-- =====================================================
        BRAND / LOGO
    ====================================================== --}}
    <div class="h-[76px] shrink-0 flex items-center gap-3 px-5
                bg-[#111c33] border-b border-slate-700/60">

        <div class="w-10 h-10 shrink-0 rounded-xl bg-white
                    flex items-center justify-center
                    shadow-sm overflow-hidden">
            <img src="{{ asset('images/ahass.webp') }}"
                 alt="AHASS"
                 class="h-8 w-auto object-contain">
        </div>

        <div class="min-w-0">
            <p class="text-[13px] font-bold tracking-wide text-white truncate">
                AHASS
            </p>
            <p class="text-[11px] font-medium text-slate-400 truncate">
                SURYA WIJAYA
            </p>
        </div>
    </div>


    {{-- =====================================================
        NAVIGATION
    ====================================================== --}}
    <nav class="flex-1 px-3 py-5 overflow-y-auto space-y-1
                scrollbar-thin scrollbar-thumb-slate-700
                scrollbar-track-transparent">

        {{-- =================================================
            ANTREAN
        ================================================== --}}
        @if (! auth()->user()->hasRole('mekanik'))

        <a href="{{ route('antrean.index') }}"
           class="group relative flex items-center gap-3 px-3.5 py-3 rounded-xl
                  text-[13px] font-medium transition-all duration-200
                  {{ request()->routeIs('antrean.*')
                        ? 'bg-red-600 text-white shadow-lg shadow-red-900/20'
                        : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">

            {{-- Active indicator --}}
            @if (request()->routeIs('antrean.*'))
                <span class="absolute left-0 top-2 bottom-2 w-1
                             bg-white rounded-r-full"></span>
            @endif

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-[19px] h-[19px] shrink-0
                        {{ request()->routeIs('antrean.*')
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white' }}"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>

            <span class="truncate">
                Antrean
            </span>
        </a>

        @endif


        {{-- =================================================
            TUGAS SAYA - MEKANIK
        ================================================== --}}
        @if (auth()->user()->hasRole('mekanik'))

        <a href="{{ route('mekanik.dashboard') }}"
           class="group relative flex items-center gap-3 px-3.5 py-3 rounded-xl
                  text-[13px] font-medium transition-all duration-200
                  {{ request()->routeIs('mekanik.dashboard')
                        ? 'bg-red-600 text-white shadow-lg shadow-red-900/20'
                        : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">

            @if (request()->routeIs('mekanik.dashboard'))
                <span class="absolute left-0 top-2 bottom-2 w-1
                             bg-white rounded-r-full"></span>
            @endif

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-[19px] h-[19px] shrink-0
                        {{ request()->routeIs('mekanik.dashboard')
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white' }}"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>

            <span class="truncate">
                Tugas Saya
            </span>
        </a>

        @endif


        {{-- =================================================
            PKB
        ================================================== --}}
        @can('buat pkb')

        <a href="{{ route('pkb.index') }}"
           class="group relative flex items-center gap-3 px-3.5 py-3 rounded-xl
                  text-[13px] font-medium transition-all duration-200
                  {{ request()->routeIs('pkb.*')
                        ? 'bg-red-600 text-white shadow-lg shadow-red-900/20'
                        : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">

            @if (request()->routeIs('pkb.*'))
                <span class="absolute left-0 top-2 bottom-2 w-1
                             bg-white rounded-r-full"></span>
            @endif

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-[19px] h-[19px] shrink-0
                        {{ request()->routeIs('pkb.*')
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white' }}"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>

            <span class="truncate">
                PKB
            </span>
        </a>

        @endcan


        {{-- =================================================
            MONITOR BOARD
        ================================================== --}}
        <a href="{{ route('monitor.board') }}"
           target="_blank"
           class="group flex items-center gap-3 px-3.5 py-3 rounded-xl
                  text-[13px] font-medium text-slate-300
                  hover:bg-slate-800/80 hover:text-white
                  transition-all duration-200">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-[19px] h-[19px] shrink-0 text-slate-400
                        group-hover:text-white transition"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>

            <span class="truncate">
                Monitor Board
            </span>

            {{-- External indicator --}}
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-3.5 h-3.5 ml-auto text-slate-500
                        group-hover:text-slate-300"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M14 5h5m0 0v5m0-5l-7 7m-2-7H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4" />
            </svg>
        </a>


        {{-- =================================================
            MASTER DATA
        ================================================== --}}
        @can('manage mekanik')

        <div class="pt-6 pb-2 px-3">
            <div class="flex items-center gap-2">

                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>

                <span class="text-[10px] font-bold text-slate-500
                             uppercase tracking-[0.18em]">
                    Master Data
                </span>

                <div class="flex-1 h-px bg-slate-800 ml-1"></div>
            </div>
        </div>


        {{-- Data Mekanik --}}
        <a href="{{ route('mekanik.index') }}"
           class="group relative flex items-center gap-3 px-3.5 py-3 rounded-xl
                  text-[13px] font-medium transition-all duration-200
                  {{ request()->routeIs('mekanik.index')
                        ? 'bg-red-600 text-white shadow-lg shadow-red-900/20'
                        : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">

            @if (request()->routeIs('mekanik.index'))
                <span class="absolute left-0 top-2 bottom-2 w-1
                             bg-white rounded-r-full"></span>
            @endif

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-[19px] h-[19px] shrink-0
                        {{ request()->routeIs('mekanik.index')
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white' }}"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M15.982 3.827a1 1 0 011.6.294l1.02 2.04 2.256.328a1 1 0 01.554 1.706l-1.632 1.591.385 2.247a1 1 0 01-1.451 1.054L16.68 12l-2.034 1.087a1 1 0 01-1.451-1.054l.385-2.247-1.632-1.591a1 1 0 01.554-1.706l2.256-.328zM6 14a3 3 0 100-6 3 3 0 000 6zm0 0c-2.21 0-6 1.343-6 4v1h9v-1c0-.653-.184-1.27-.5-1.816" />
            </svg>

            <span class="truncate">
                Data Mekanik
            </span>
        </a>

        @endcan


        {{-- Jenis Pekerjaan --}}
        @can('manage jenis pekerjaan')

        <a href="{{ route('jenis-pekerjaan.index') }}"
           class="group relative flex items-center gap-3 px-3.5 py-3 rounded-xl
                  text-[13px] font-medium transition-all duration-200
                  {{ request()->routeIs('jenis-pekerjaan.index')
                        ? 'bg-red-600 text-white shadow-lg shadow-red-900/20'
                        : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">

            @if (request()->routeIs('jenis-pekerjaan.index'))
                <span class="absolute left-0 top-2 bottom-2 w-1
                             bg-white rounded-r-full"></span>
            @endif

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-[19px] h-[19px] shrink-0
                        {{ request()->routeIs('jenis-pekerjaan.index')
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white' }}"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>

            <span class="truncate">
                Jenis Pekerjaan
            </span>
        </a>

        @endcan


        {{-- Pengguna & Role --}}
        @can('manage users')

        <a href="{{ route('users.index') }}"
           class="group relative flex items-center gap-3 px-3.5 py-3 rounded-xl
                  text-[13px] font-medium transition-all duration-200
                  {{ request()->routeIs('users.index')
                        ? 'bg-red-600 text-white shadow-lg shadow-red-900/20'
                        : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">

            @if (request()->routeIs('users.index'))
                <span class="absolute left-0 top-2 bottom-2 w-1
                             bg-white rounded-r-full"></span>
            @endif

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-[19px] h-[19px] shrink-0
                        {{ request()->routeIs('users.index')
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white' }}"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>

            <span class="truncate">
                Pengguna & Role
            </span>
        </a>

        @endcan


        {{-- =================================================
            LAPORAN
        ================================================== --}}
        @can('view laporan')

        <div class="pt-6 pb-2 px-3">
            <div class="flex items-center gap-2">

                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>

                <span class="text-[10px] font-bold text-slate-500
                             uppercase tracking-[0.18em]">
                    Laporan
                </span>

                <div class="flex-1 h-px bg-slate-800 ml-1"></div>
            </div>
        </div>


        <a href="{{ route('laporan.index') }}"
           class="group relative flex items-center gap-3 px-3.5 py-3 rounded-xl
                  text-[13px] font-medium transition-all duration-200
                  {{ request()->routeIs('laporan.index')
                        ? 'bg-red-600 text-white shadow-lg shadow-red-900/20'
                        : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">

            @if (request()->routeIs('laporan.index'))
                <span class="absolute left-0 top-2 bottom-2 w-1
                             bg-white rounded-r-full"></span>
            @endif

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-[19px] h-[19px] shrink-0
                        {{ request()->routeIs('laporan.index')
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white' }}"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M9 17V9m4 8V5m4 12v-4M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>

            <span class="truncate">
                Laporan
            </span>
        </a>

        @endcan

    </nav>


    {{-- =====================================================
        USER PROFILE + LOGOUT
    ====================================================== --}}
    <div class="shrink-0 p-3 border-t border-slate-700/60
                bg-[#111c33]">

        {{-- User Card --}}
        <a href="{{ route('profile.edit') }}"
           class="group flex items-center gap-3 p-2.5 rounded-xl
                  bg-slate-800/50 border border-slate-700/60
                  hover:bg-slate-800
                  hover:border-slate-600
                  transition-all duration-200">

            {{-- Avatar --}}
            @if (auth()->user()->foto_url)

                <img src="{{ auth()->user()->foto_url }}"
                     class="w-10 h-10 rounded-xl object-cover shrink-0
                            ring-2 ring-slate-700"
                     alt="Foto profil">

            @else

                <div class="w-10 h-10 rounded-xl
                            bg-gradient-to-br from-red-500 to-red-700
                            flex items-center justify-center
                            text-white text-sm font-bold shrink-0
                            shadow-md shadow-red-900/20">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

            @endif


            {{-- User Information --}}
            <div class="min-w-0 flex-1">

                <p class="text-[13px] font-semibold text-white truncate">
                    {{ auth()->user()->name }}
                </p>

                <p class="text-[11px] text-slate-400 truncate mt-0.5">
                    {{ auth()->user()->getRoleNames()->first() ?? '-' }}
                </p>

            </div>


            {{-- Arrow --}}
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-4 h-4 text-slate-500
                        group-hover:text-slate-300
                        transition"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M9 5l7 7-7 7" />
            </svg>

        </a>


        {{-- Logout --}}
        <form method="POST"
              action="{{ route('logout') }}"
              class="mt-2">

            @csrf

            <button type="submit"
                    class="group w-full flex items-center gap-3
                           px-3.5 py-2.5 rounded-xl
                           text-[13px] font-medium
                           text-slate-400
                           hover:bg-red-500/10
                           hover:text-red-400
                           transition-all duration-200">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-[19px] h-[19px] shrink-0
                            group-hover:text-red-400 transition"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>

                <span>
                    Keluar
                </span>

            </button>

        </form>

    </div>

</aside>