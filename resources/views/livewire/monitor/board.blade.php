<div
    wire:poll.5s
    class="h-screen flex flex-col
           bg-[#0b1220] text-white
           p-5 sm:p-6 lg:p-8 xl:p-10
           overflow-hidden"
    x-data="{ now: new Date() }"
    x-init="setInterval(() => now = new Date(), 1000)"
>

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div
        class="relative flex items-center justify-between
               gap-6 mb-6 lg:mb-7 shrink-0"
    >

        {{-- Garis aksen AHASS --}}
        <div
            class="absolute
                   -top-5 sm:-top-6 lg:-top-8 xl:-top-10
                   left-0 right-0
                   h-1
                   bg-gradient-to-r
                   from-red-600
                   via-red-500
                   to-transparent"
        ></div>


        {{-- =====================================================
            BRAND
        ====================================================== --}}
        <div class="flex items-center gap-4 min-w-0">

            {{-- Logo --}}
            <div
                class="w-14 h-14 lg:w-16 lg:h-16
                       rounded-2xl
                       bg-white
                       flex items-center justify-center
                       shrink-0
                       overflow-hidden
                       shadow-xl shadow-black/20"
            >
                <img
                    src="{{ asset('images/ahass.webp') }}"
                    alt="AHASS"
                    class="h-11 lg:h-12 w-auto object-contain"
                >
            </div>


            {{-- Nama --}}
            <div class="min-w-0">

                <div
                    class="flex items-center gap-2 mb-1"
                >
                    <span
                        class="w-2 h-2
                               rounded-full
                               bg-red-500
                               animate-pulse"
                    ></span>

                    <span
                        class="text-[10px] lg:text-xs
                               font-bold
                               tracking-[0.2em]
                               uppercase
                               text-red-400"
                    >
                        Live Monitor
                    </span>
                </div>


                <h1
                    class="text-2xl lg:text-3xl xl:text-4xl
                           font-black
                           tracking-tight
                           text-white
                           leading-none"
                >
                    AHASS-SURYA WIJAYA
                </h1>


                <p
                    class="mt-1.5
                           text-xs lg:text-sm
                           text-slate-400"
                >
                    Papan monitor pekerjaan mekanik
                </p>

            </div>

        </div>


        {{-- =====================================================
            CLOCK
        ====================================================== --}}
        <div
            class="shrink-0
                   text-right
                   bg-[#111b2d]
                   border border-slate-700/60
                   rounded-2xl
                   px-5 py-3
                   lg:px-6 lg:py-4
                   shadow-xl shadow-black/10"
        >

            <div
                class="text-2xl lg:text-4xl xl:text-5xl
                       font-black
                       tracking-tight
                       tabular-nums
                       text-white
                       leading-none"
                x-text="
                    now.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    })
                "
            ></div>

            <div
                class="mt-1.5
                       text-[11px] lg:text-xs xl:text-sm
                       font-medium
                       text-slate-400"
                x-text="
                    now.toLocaleDateString('id-ID', {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    })
                "
            ></div>

        </div>

    </div>


   


    {{-- =========================================================
        GRID 5 MEKANIK
        SELALU 5 KOLOM DALAM 1 BARIS
    ========================================================== --}}
    <div
        class="flex-1
               min-h-0
               grid
               grid-cols-5
               gap-4
               lg:gap-5
               items-stretch"
    >

        @foreach ($mekaniks as $mekanik)

            @php
                $tugas = $mekanik->antreanAktif;
            @endphp


            {{-- =================================================
                KARTU MEKANIK
            ================================================== --}}
            <div
                @class([
                    'group relative
                     h-full min-h-0
                     rounded-3xl
                     p-4 lg:p-5
                     flex flex-col
                     overflow-hidden
                     transition-all duration-300',

                    // Mekanik tidak ada tugas
                    'bg-[#111b2d]
                     border border-slate-700/60
                     shadow-xl shadow-black/10
                     hover:border-slate-600'
                        => ! $tugas,

                    // Mekanik sedang bekerja
                    'bg-gradient-to-br
                     from-[#18263d]
                     via-[#132037]
                     to-[#0f1a2d]
                     border border-red-500/30
                     shadow-2xl shadow-red-950/20'
                        => $tugas,
                ])
            >

                {{-- =================================================
                    DECORATION UNTUK KARTU AKTIF
                ================================================== --}}
                @if ($tugas)

                    <div
                        class="absolute
                               -top-20
                               -right-20
                               w-40 h-40
                               rounded-full
                               bg-red-600/10
                               blur-3xl
                               pointer-events-none"
                    ></div>


                    <div
                        class="absolute
                               bottom-0
                               left-0
                               right-0
                               h-1
                               bg-gradient-to-r
                               from-red-600
                               via-red-400
                               to-transparent"
                    ></div>

                @endif


                {{-- =================================================
                    HEADER MEKANIK
                ================================================== --}}
                <div
                    class="relative
                           flex items-center
                           justify-between
                           gap-2
                           pb-4
                           border-b
                           {{ $tugas
                                ? 'border-red-500/15'
                                : 'border-slate-700/60' }}"
                >

                    <div
                        class="flex items-center
                               gap-3
                               min-w-0"
                    >

                        {{-- Foto --}}
                        @if ($mekanik->user?->foto_url)

                            <img
                                src="{{ $mekanik->user->foto_url }}"
                                alt="{{ $mekanik->nama }}"
                                class="
                                    w-11 h-11
                                    lg:w-12 lg:h-12
                                    rounded-2xl
                                    object-cover
                                    shrink-0
                                    ring-2
                                    {{ $tugas
                                        ? 'ring-red-500/50'
                                        : 'ring-slate-700' }}
                                "
                            >

                        @else

                            <div
                                @class([
                                    'w-11 h-11
                                     lg:w-12 lg:h-12
                                     rounded-2xl
                                     flex items-center justify-center
                                     font-black
                                     text-base
                                     lg:text-lg
                                     shrink-0',

                                    'bg-slate-800
                                     text-slate-400
                                     border border-slate-700'
                                        => ! $tugas,

                                    'bg-gradient-to-br
                                     from-red-500
                                     to-red-700
                                     text-white
                                     shadow-lg
                                     shadow-red-900/30'
                                        => $tugas,
                                ])
                            >
                                {{ strtoupper(substr($mekanik->nama, 0, 1)) }}
                            </div>

                        @endif


                        {{-- Nama mekanik --}}
                        <div class="min-w-0">

                            <p
                                class="font-bold
                                       text-sm
                                       lg:text-base
                                       xl:text-lg
                                       text-white
                                       truncate"
                            >
                                {{ $mekanik->nama }}
                            </p>

                            <p
                                class="text-[10px]
                                       lg:text-xs
                                       font-medium
                                       mt-0.5
                                       truncate
                                       {{ $tugas
                                            ? 'text-red-400'
                                            : 'text-slate-500' }}"
                            >
                                {{ $tugas
                                    ? 'Sedang bekerja'
                                    : 'Siap menerima tugas' }}
                            </p>

                        </div>

                    </div>


                    {{-- Status indicator --}}
                    <div
                        class="shrink-0
                               w-7 h-7
                               lg:w-8 lg:h-8
                               rounded-xl
                               flex items-center justify-center
                               {{ $tugas
                                    ? 'bg-red-500/10 text-red-400'
                                    : 'bg-emerald-500/10 text-emerald-400' }}"
                    >

                        @if ($tugas)

                            <span
                                class="w-2
                                       lg:w-2.5
                                       h-2
                                       lg:h-2.5
                                       rounded-full
                                       bg-red-500
                                       animate-pulse"
                            ></span>

                        @else

                            <span
                                class="w-2
                                       lg:w-2.5
                                       h-2
                                       lg:h-2.5
                                       rounded-full
                                       bg-emerald-400"
                            ></span>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                    KONTEN SAAT ADA TUGAS
                ================================================== --}}
                @if ($tugas)

                    <div
                        class="relative
                               flex-1
                               min-h-0
                               flex flex-col
                               pt-4 lg:pt-5"
                    >

                        {{-- Badge --}}
                        <div class="mb-4">

                            <span
                                class="inline-flex
                                       items-center
                                       gap-1.5
                                       px-2.5
                                       py-1.5
                                       rounded-full
                                       bg-red-500/10
                                       border border-red-500/20
                                       text-[9px]
                                       lg:text-[10px]
                                       font-bold
                                       uppercase
                                       tracking-[0.12em]
                                       text-red-300"
                            >

                                <span
                                    class="w-1.5
                                           h-1.5
                                           rounded-full
                                           bg-red-400
                                           animate-pulse"
                                ></span>

                                Sedang Dikerjakan

                            </span>

                        </div>


                        {{-- =================================================
                            NOMOR POLISI
                        ================================================== --}}
                        <div class="mb-4">

                            <p
                                class="text-[9px]
                                       lg:text-[10px]
                                       uppercase
                                       tracking-[0.18em]
                                       font-bold
                                       text-slate-500
                                       mb-1"
                            >
                                Nomor Polisi
                            </p>

                            <p
                                class="text-2xl
                                       lg:text-3xl
                                       xl:text-4xl
                                       font-black
                                       tracking-wide
                                       text-white
                                       leading-none
                                       truncate"
                                title="{{ $tugas->no_polisi }}"
                            >
                                {{ $tugas->no_polisi }}
                            </p>

                        </div>


                        {{-- =================================================
                            MOTOR + WAKTU
                        ================================================== --}}
                        <div
                            class="grid grid-cols-2
                                   gap-3"
                        >

                            {{-- Motor --}}
                            <div class="min-w-0">

                                <p
                                    class="text-[9px]
                                           lg:text-[10px]
                                           uppercase
                                           tracking-[0.15em]
                                           font-bold
                                           text-slate-500
                                           mb-1"
                                >
                                    Motor
                                </p>

                                <p
                                    class="text-xs
                                           lg:text-sm
                                           font-semibold
                                           text-slate-200
                                           truncate"
                                    title="{{ $tugas->tipe_motor }}"
                                >
                                    {{ $tugas->tipe_motor }}
                                </p>

                            </div>


                            {{-- Jam --}}
                            <div
                                class="text-right
                                       min-w-0"
                            >

                                <p
                                    class="text-[9px]
                                           lg:text-[10px]
                                           uppercase
                                           tracking-[0.15em]
                                           font-bold
                                           text-slate-500
                                           mb-1"
                                >
                                    Mulai
                                </p>

                                <p
                                    class="text-xs
                                           lg:text-sm
                                           font-semibold
                                           text-slate-200"
                                >
                                    {{ $tugas->jam_masuk->format('H:i') }}
                                </p>

                            </div>

                        </div>


                        {{-- =================================================
                            PEKERJAAN
                        ================================================== --}}
                        <div
                            class="mt-auto
                                   pt-4
                                   mt-5
                                   border-t border-red-500/15"
                        >

                            <p
                                class="text-[9px]
                                       lg:text-[10px]
                                       uppercase
                                       tracking-[0.15em]
                                       font-bold
                                       text-slate-500
                                       mb-1"
                            >
                                Pekerjaan
                            </p>

                            <p
                                class="text-xs
                                       lg:text-sm
                                       font-semibold
                                       text-slate-200
                                       leading-snug
                                       line-clamp-2"
                                title="{{ $tugas->jenisPekerjaan->nama_pekerjaan ?? 'Belum ditentukan' }}"
                            >
                                {{ $tugas->jenisPekerjaan->nama_pekerjaan ?? 'Belum ditentukan' }}
                            </p>

                        </div>

                    </div>


                {{-- =================================================
                    KONTEN SAAT TIDAK ADA TUGAS
                ================================================== --}}
                @else

                    <div
                        class="flex-1
                               min-h-0
                               flex flex-col
                               items-center
                               justify-center
                               text-center
                               px-3"
                    >

                        {{-- Icon --}}
                        <div
                            class="w-14 h-14
                                   lg:w-16 lg:h-16
                                   rounded-2xl
                                   bg-slate-800/70
                                   border border-slate-700
                                   flex items-center justify-center
                                   mb-4"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6
                                       lg:w-7 lg:h-7
                                       text-slate-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 6v6h4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>

                        </div>


                        <p
                            class="text-xs
                                   lg:text-sm
                                   font-semibold
                                   text-slate-400"
                        >
                            Belum ada pekerjaan
                        </p>

                        <p
                            class="text-[10px]
                                   lg:text-xs
                                   text-slate-600
                                   mt-1"
                        >
                            Siap menerima tugas baru
                        </p>

                    </div>

                @endif

            </div>

        @endforeach

    </div>


    {{-- =========================================================
        FOOTER
    ========================================================== --}}
    <div
        class="shrink-0
               pt-4
               mt-5
               border-t border-slate-800/80
               flex items-center
               justify-between
               gap-4"
    >

        <div
            class="flex items-center gap-2
                   text-[10px]
                   lg:text-xs
                   text-slate-500"
        >

            <span
                class="w-1.5 h-1.5
                       rounded-full
                       bg-emerald-400"
            ></span>

            <span>
                Sistem berjalan normal
            </span>

        </div>


        <p
            class="text-[10px]
                   lg:text-xs
                   text-slate-600"
        >
            AHASS-SURYA WIJAYA
        </p>

    </div>

</div>