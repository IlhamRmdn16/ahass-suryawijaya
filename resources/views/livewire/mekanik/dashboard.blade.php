<div wire:poll.10s>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Halo, {{ auth()->user()->name }} 👋</h1>
        <p class="text-sm text-slate-500">Berikut daftar pekerjaan yang sudah ditugaskan ke kamu.</p>
    </div>

    @if (session('message'))
        <div class="mb-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm">
            {{ session('message') }}
        </div>
    @endif

    {{-- Tugas yang sedang dikerjakan --}}
    <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-3">Sedang Dikerjakan</h2>

    @forelse ($tugasAktif as $tugas)
        <div class="bg-white border border-slate-200 rounded-2xl p-5 mb-4 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-lg font-bold text-slate-900">{{ $tugas->no_polisi }}</span>
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Dikerjakan</span>
                    </div>
                    <p class="text-slate-600">{{ $tugas->tipe_motor }}</p>
                    <p class="text-slate-600">{{ $tugas->jenisPekerjaan->nama_pekerjaan }}</p>
                    <p class="text-xs text-slate-400 mt-1">Mulai jam {{ $tugas->jam_masuk->format('H:i') }}</p>
                </div>

                <button wire:click="selesaikan({{ $tugas->id }})"
                    wire:confirm="Tandai pekerjaan {{ $tugas->no_polisi }} sebagai selesai?"
                    class="shrink-0 w-full sm:w-auto px-8 py-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-base transition">
                    ✓ Selesai
                </button>
            </div>
        </div>
    @empty
        <div class="bg-white border border-dashed border-slate-300 rounded-2xl p-10 text-center text-slate-400 mb-6">
            Belum ada pekerjaan yang ditugaskan ke kamu saat ini.
        </div>
    @endforelse

    {{-- Riwayat selesai hari ini --}}
    @if ($riwayatHariIni->isNotEmpty())
        <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wide mt-8 mb-3">Selesai Hari Ini</h2>
        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <tbody class="divide-y divide-slate-100">
                    @foreach ($riwayatHariIni as $riwayat)
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-700">{{ $riwayat->no_polisi }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $riwayat->tipe_motor }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $riwayat->jenisPekerjaan->nama_pekerjaan }}</td>
                            <td class="px-4 py-3 text-slate-500 whitespace-nowrap">
                                {{ $riwayat->jam_masuk->format('H:i') }} &ndash; {{ $riwayat->jam_selesai->format('H:i') }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Selesai</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
