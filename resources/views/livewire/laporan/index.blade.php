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
        <div class="px-4 py-3 border-b border-slate-100">
            <h2 class="text-sm font-semibold text-slate-700">Detail Antrean</h2>
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
                            <td class="px-4 py-2.5 text-slate-600">{{ $antrean->jenisPekerjaan->nama_pekerjaan }}</td>
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
