<div>

    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Laporan Antrean</h1>
        <p class="text-sm text-slate-500 mt-1">Rekap data servis berdasarkan rentang tanggal.</p>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
            <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Dari Tanggal</label>
            <input type="date" wire:model.live="tanggal_awal"
                class="w-full rounded-xl border-slate-300 text-sm focus:ring-red-500 focus:border-red-500">
        </div>
        <div>
            <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
            <input type="date" wire:model.live="tanggal_akhir"
                class="w-full rounded-xl border-slate-300 text-sm focus:ring-red-500 focus:border-red-500">
        </div>
        <div>
            <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Status</label>
            <select wire:model.live="filterStatus"
                class="w-full rounded-xl border-slate-300 text-sm focus:ring-red-500 focus:border-red-500">
                <option value="semua">Semua Status</option>
                <option value="menunggu">Menunggu</option>
                <option value="dikerjakan">Dikerjakan</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>
        <div>
            <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Mekanik</label>
            <select wire:model.live="filterMekanik"
                class="w-full rounded-xl border-slate-300 text-sm focus:ring-red-500 focus:border-red-500">
                <option value="semua">Semua Mekanik</option>
                @foreach ($daftarMekanik as $mekanik)
                    <option value="{{ $mekanik->id }}">{{ $mekanik->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Kartu ringkasan --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-slate-400 shadow-sm px-4 py-3.5">
            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Total Masuk</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $totalMasuk }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-amber-400 shadow-sm px-4 py-3.5">
            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Menunggu</p>
            <p class="text-2xl font-bold text-amber-600 mt-1">{{ $totalMenunggu }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-blue-500 shadow-sm px-4 py-3.5">
            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Dikerjakan</p>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalDikerjakan }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-emerald-500 shadow-sm px-4 py-3.5">
            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Selesai</p>
            <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $totalSelesai }}</p>
        </div>
    </div>

    {{-- Rekap per mekanik --}}
    @php $maksSelesai = max($rekapMekanik->max('total_selesai') ?? 0, 1); @endphp
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
        <div class="px-5 py-4 border-b border-slate-100">
            <h2 class="text-sm font-semibold text-slate-800">Rekap per Mekanik</h2>
            <p class="text-xs text-slate-400 mt-0.5">Jumlah pekerjaan selesai dan rata-rata durasi pengerjaan.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Mekanik</th>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Total Selesai</th>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Rata-rata Durasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($rekapMekanik as $mekanik)
                        <tr class="hover:bg-red-50/40 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-red-600 to-red-800 flex items-center justify-center text-white text-xs font-semibold shrink-0">
                                        {{ strtoupper(substr($mekanik->nama, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-slate-800">{{ $mekanik->nama }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <span class="w-24 text-slate-700 tabular-nums">{{ $mekanik->total_selesai }} pekerjaan</span>
                                    <div class="hidden sm:block h-1.5 w-32 rounded-full bg-slate-100 overflow-hidden">
                                        <div class="h-full rounded-full bg-gradient-to-r from-red-600 to-red-400"
                                             style="width: {{ ($mekanik->total_selesai / $maksSelesai) * 100 }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 tabular-nums">
                                {{ $mekanik->rata_rata_menit !== null ? $mekanik->rata_rata_menit . ' menit' : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-5 py-10 text-center text-slate-400">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Detail antrean --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
            <div>
                <h2 class="text-sm font-semibold text-slate-800">Detail Antrean</h2>
                <p class="text-xs text-slate-400 mt-0.5">Mengikuti filter di atas.</p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <label class="text-xs text-slate-500 whitespace-nowrap">Tanggal cetak</label>
                <input type="date" wire:model.live="tanggalPrint"
                    class="rounded-lg border-slate-300 text-xs py-1.5 focus:ring-red-500 focus:border-red-500">
                <a href="{{ route('laporan.print', ['tanggal' => $tanggalPrint]) }}" target="_blank"
                    class="inline-flex items-center gap-1.5 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white text-xs font-semibold px-3.5 py-2 rounded-lg shadow-md shadow-red-500/25 transition whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                    </svg>
                    Cetak Unit Entry (A4)
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">No Polisi</th>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Motor</th>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Mekanik</th>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">JP</th>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Jam</th>
                        <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($antreans as $antrean)
                        <tr class="hover:bg-red-50/40 transition-colors">
                            <td class="px-5 py-3.5 text-slate-600 whitespace-nowrap tabular-nums">{{ $antrean->tanggal->format('d/m/Y') }}</td>
                            <td class="px-5 py-3.5">
                                <span class="inline-block px-2.5 py-1 rounded-md border border-slate-300 bg-white text-slate-900 font-bold tracking-wider text-xs shadow-sm">
                                    {{ $antrean->no_polisi }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $antrean->tipe_motor }}</td>
                            <td class="px-5 py-3.5 text-slate-700">{{ $antrean->mekanik->nama ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $antrean->jenisPekerjaan->nama_pekerjaan ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-slate-600 whitespace-nowrap tabular-nums">
                                {{ $antrean->jam_masuk->format('H:i') }}
                                <span class="text-slate-300 mx-0.5">&ndash;</span>
                                {{ $antrean->jam_selesai?->format('H:i') ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span @class([
                                    'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold whitespace-nowrap',
                                    'bg-amber-50 text-amber-700 ring-1 ring-amber-200' => $antrean->status === 'menunggu',
                                    'bg-blue-50 text-blue-700 ring-1 ring-blue-200' => $antrean->status === 'dikerjakan',
                                    'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' => $antrean->status === 'selesai',
                                ])>
                                    <span @class([
                                        'w-1.5 h-1.5 rounded-full',
                                        'bg-amber-500' => $antrean->status === 'menunggu',
                                        'bg-blue-500' => $antrean->status === 'dikerjakan',
                                        'bg-emerald-500' => $antrean->status === 'selesai',
                                    ])></span>
                                    {{ $antrean->status_label }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-14 text-center">
                                <p class="text-sm font-semibold text-slate-600">Tidak ada data</p>
                                <p class="text-xs text-slate-400 mt-1">Tidak ada data pada rentang atau filter ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer: jumlah baris per halaman + info + paginasi --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-3 px-5 py-3 border-t border-slate-100 bg-slate-50/60">
            <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-4 text-xs text-slate-500">
                <label class="flex items-center gap-2">
                    Tampilkan
                    <select wire:model.live="perPage"
                        class="rounded-lg border-slate-200 bg-white text-xs py-1 pl-2 pr-7 shadow-sm focus:ring-red-500 focus:border-red-500">
                        @foreach ($perPageOptions as $opsi)
                            <option value="{{ $opsi }}">{{ $opsi }}</option>
                        @endforeach
                    </select>
                    data per halaman
                </label>
                <span>
                    Menampilkan
                    <strong class="text-slate-700">{{ $antreans->firstItem() ?? 0 }}</strong>&ndash;<strong class="text-slate-700">{{ $antreans->lastItem() ?? 0 }}</strong>
                    dari <strong class="text-slate-700">{{ $antreans->total() }}</strong> data
                </span>
            </div>

            @if ($antreans->hasPages())
                <div>{{ $antreans->links() }}</div>
            @endif
        </div>
    </div>
</div>
