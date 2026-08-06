<div>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Laporan Antrean</h1>
        <p class="text-sm text-slate-500">Rekap data servis berdasarkan rentang tanggal.</p>
    </div>

    {{-- Filter --}}
    <div class="bg-white border border-slate-200 rounded-xl p-4 mb-6 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">Dari Tanggal</label>
            <input type="date" wire:model.live="tanggal_awal"
                class="rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">Sampai Tanggal</label>
            <input type="date" wire:model.live="tanggal_akhir"
                class="rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">Status</label>
            <select wire:model.live="filterStatus" class="rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
                <option value="semua">Semua Status</option>
                <option value="menunggu">Menunggu</option>
                <option value="dikerjakan">Dikerjakan</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">Mekanik</label>
            <select wire:model.live="filterMekanik" class="rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
                <option value="semua">Semua Mekanik</option>
                @foreach ($daftarMekanik as $mekanik)
                    <option value="{{ $mekanik->id }}">{{ $mekanik->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Kartu Ringkasan --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Total Masuk</p>
            <p class="text-2xl font-bold text-slate-800">{{ $totalMasuk }}</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Menunggu</p>
            <p class="text-2xl font-bold text-amber-600">{{ $totalMenunggu }}</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Dikerjakan</p>
            <p class="text-2xl font-bold text-blue-600">{{ $totalDikerjakan }}</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Selesai</p>
            <p class="text-2xl font-bold text-emerald-600">{{ $totalSelesai }}</p>
        </div>
    </div>

    {{-- Rekap per Mekanik --}}
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden mb-6">
        <div class="px-4 py-3 border-b border-slate-100">
            <h2 class="text-sm font-semibold text-slate-700">Rekap per Mekanik</h2>
        </div>
        <table class="min-w-full divide-y divide-slate-100 text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase">Mekanik</th>
                    <th class="px-4 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase">Total Selesai</th>
                    <th class="px-4 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase">Rata-rata Durasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($rekapMekanik as $mekanik)
                    <tr>
                        <td class="px-4 py-2.5 font-medium text-slate-800">{{ $mekanik->nama }}</td>
                        <td class="px-4 py-2.5 text-slate-600">{{ $mekanik->total_selesai }} pekerjaan</td>
                        <td class="px-4 py-2.5 text-slate-600">
                            {{ $mekanik->rata_rata_menit ? $mekanik->rata_rata_menit . ' menit' : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-6 text-center text-slate-400">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Detail Antrean --}}
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
        <div class="px-4 py-3 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h2 class="text-sm font-semibold text-slate-700">Detail Antrean</h2>

            <div class="flex items-center gap-2">
                <label class="text-xs text-slate-500 whitespace-nowrap">Tanggal cetak:</label>
                <input type="date" wire:model.live="tanggalPrint"
                    class="rounded-lg border-slate-300 text-xs py-1.5 focus:ring-slate-800 focus:border-slate-800">
                <a href="{{ route('laporan.print', ['tanggal' => $tanggalPrint]) }}" target="_blank"
                    class="inline-flex items-center gap-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                    </svg>
                    Cetak Unit Entry (A4)
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase">Tanggal</th>
                        <th class="px-4 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase">No Polisi</th>
                        <th class="px-4 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase">Motor</th>
                        <th class="px-4 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase">Mekanik</th>
                        <th class="px-4 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase">JP</th>
                        <th class="px-4 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase">Jam</th>
                        <th class="px-4 py-2.5 text-left text-xs font-semibold text-slate-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($antreans as $antrean)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-2.5 text-slate-600 whitespace-nowrap">{{ $antrean->tanggal->format('d/m/Y') }}</td>
                            <td class="px-4 py-2.5 font-medium text-slate-800">{{ $antrean->no_polisi }}</td>
                            <td class="px-4 py-2.5 text-slate-600">{{ $antrean->tipe_motor }}</td>
                            <td class="px-4 py-2.5 text-slate-600">{{ $antrean->mekanik->nama ?? '-' }}</td>
                            <td class="px-4 py-2.5 text-slate-600">{{ $antrean->jenisPekerjaan->nama_pekerjaan ?? '-' }}</td>
                            <td class="px-4 py-2.5 text-slate-600 whitespace-nowrap">
                                {{ $antrean->jam_masuk->format('H:i') }} &ndash; {{ $antrean->jam_selesai?->format('H:i') ?? '-' }}
                            </td>
                            <td class="px-4 py-2.5">
                                <span @class([
                                    'px-2.5 py-1 rounded-full text-xs font-semibold whitespace-nowrap',
                                    'bg-amber-100 text-amber-700' => $antrean->status === 'menunggu',
                                    'bg-blue-100 text-blue-700' => $antrean->status === 'dikerjakan',
                                    'bg-emerald-100 text-emerald-700' => $antrean->status === 'selesai',
                                ])>
                                    {{ $antrean->status_label }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-10 text-center text-slate-400">Tidak ada data pada rentang/filter ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $antreans->links() }}
    </div>
</div>
