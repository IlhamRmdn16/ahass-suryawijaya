<div wire:poll.5s class="min-h-screen flex flex-col p-6 lg:p-10" x-data="{ now: new Date() }" x-init="setInterval(() => now = new Date(), 1000)">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8 lg:mb-10">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-red-600 flex items-center justify-center font-bold text-lg">A</div>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">AHASS &mdash; Status Bengkel</h1>
                <p class="text-slate-400 text-sm lg:text-base">Papan monitor pekerjaan mekanik</p>
            </div>
        </div>

        <div class="text-right">
            <div class="text-3xl lg:text-5xl font-bold tabular-nums" x-text="now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' })"></div>
            <div class="text-slate-400 text-sm lg:text-base" x-text="now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })"></div>
        </div>
    </div>

    {{-- Info antrean menunggu --}}
    @if ($jumlahMenunggu > 0)
        <div class="mb-6 inline-flex items-center gap-2 bg-amber-500/10 border border-amber-500/30 text-amber-400 px-4 py-2 rounded-full text-sm font-medium w-fit">
            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
            {{ $jumlahMenunggu }} konsumen menunggu untuk ditugaskan
        </div>
    @endif

    {{-- Grid Mekanik --}}
    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-5">
        @foreach ($mekaniks as $mekanik)
            @php $tugas = $mekanik->antreanAktif; @endphp

            <div @class([
                'rounded-2xl p-5 flex flex-col border-2 transition',
                'bg-slate-900 border-slate-800' => ! $tugas,
                'bg-blue-950/40 border-blue-500/40' => $tugas,
            ])>
                {{-- Nama mekanik --}}
                <div class="flex items-center gap-3 mb-5">
                    @if ($mekanik->user?->foto_url)
                        <img src="{{ $mekanik->user->foto_url }}"
                             class="w-12 h-12 rounded-full object-cover shrink-0 border-2 {{ $tugas ? 'border-blue-500' : 'border-slate-700' }}"
                             alt="{{ $mekanik->nama }}">
                    @else
                        <div @class([
                            'w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg shrink-0',
                            'bg-slate-800 text-slate-400' => ! $tugas,
                            'bg-blue-600 text-white' => $tugas,
                        ])>
                            {{ strtoupper(substr($mekanik->nama, 0, 1)) }}
                        </div>
                    @endif
                    <div class="min-w-0">
                        <p class="font-semibold text-lg truncate">{{ $mekanik->nama }}</p>
                        <p @class([
                            'text-xs font-medium',
                            'text-slate-500' => ! $tugas,
                            'text-blue-400' => $tugas,
                        ])>
                            {{ $tugas ? 'Sedang bekerja' : 'Siap menerima tugas' }}
                        </p>
                    </div>
                </div>

                {{-- Isi kartu --}}
                @if ($tugas)
                    <div class="flex-1 flex flex-col justify-center gap-3">
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">No Polisi</p>
                            <p class="text-2xl font-bold">{{ $tugas->no_polisi }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Motor</p>
                            <p class="text-base text-slate-200">{{ $tugas->tipe_motor }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Pekerjaan</p>
                            <p class="text-base text-slate-200">{{ $tugas->jenisPekerjaan->nama_pekerjaan ?? 'Belum ditentukan' }}</p>
                        </div>
                        <div class="pt-2 border-t border-blue-500/20">
                            <p class="text-xs text-slate-400">Mulai jam {{ $tugas->jam_masuk->format('H:i') }}</p>
                        </div>
                    </div>
                @else
                    <div class="flex-1 flex items-center justify-center text-center py-6">
                        <p class="text-slate-600 text-sm">Belum ada pekerjaan<br>ditugaskan</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

</div>
