<div>
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">PKB &mdash; Perintah Kerja Bengkel</h1>
            <p class="text-sm text-slate-500">Formulir persetujuan data pribadi & No. PKB/WO per konsumen.</p>
        </div>

        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">Tanggal</label>
            <input type="date" wire:model.live="tanggal"
                class="rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">No</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">No Polisi</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Tipe Motor</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">No. PKB/WO</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Status PKB</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($antreans as $i => $antrean)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 text-slate-600">{{ $i + 1 }}</td>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $antrean->nama_konsumen ?: '-' }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ $antrean->no_polisi }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ $antrean->tipe_motor }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ $antrean->pkb->no_pkb ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if (! $antrean->pkb)
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-500 whitespace-nowrap">
                                    Belum Dibuat
                                </span>
                            @elseif ($antrean->pkb->status === 'menunggu_no_pkb')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 whitespace-nowrap">
                                    Menunggu No. PKB
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 whitespace-nowrap">
                                    Selesai
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 space-x-2 whitespace-nowrap">
                            @if (! $antrean->pkb)
                                <a href="{{ route('pkb.show', $antrean->id) }}" class="text-purple-600 hover:text-purple-800 font-medium">
                                    Buat PKB
                                </a>
                            @elseif ($antrean->pkb->status === 'menunggu_no_pkb')
                                <a href="{{ route('pkb.show', $antrean->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    {{ $bisaIsiNoPkb ? 'Isi No. PKB' : 'Lihat' }}
                                </a>
                            @else
                                <a href="{{ route('pkb.show', $antrean->id) }}" class="text-slate-600 hover:text-slate-900 font-medium">
                                    Lihat
                                </a>
                                <a href="{{ route('pkb.download', $antrean->pkb->id) }}" target="_blank" class="text-emerald-600 hover:text-emerald-800 font-medium">
                                    Download PDF
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-10 text-center text-slate-400">
                            Belum ada konsumen terdaftar pada tanggal ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
