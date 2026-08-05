<div>
    {{-- Header + Filter Tanggal --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Antrean Konsumen</h1>
            <p class="text-sm text-slate-500">Daftar konsumen yang masuk pada tanggal terpilih.</p>
        </div>

        <div class="flex items-end gap-3">
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Tanggal</label>
                <input type="date" wire:model.live="tanggal"
                    class="rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
            </div>
            <button wire:click="create"
                class="inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Konsumen Baru
            </button>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if (session('message'))
        <div class="mb-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm">
            {{ session('message') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabel Antrean --}}
    <div class="bg-white border border-slate-200 rounded-xl overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">No</th>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">No Polisi</th>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Tipe Motor</th>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Jam</th>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Mekanik</th>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">JP</th>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">No. HP</th>
                    <th class="px-3 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wide">Daya Auto</th>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($antreans as $i => $antrean)
                    <tr class="hover:bg-slate-50">
                        <td class="px-3 py-3 text-slate-600">{{ $i + 1 }}</td>
                        <td class="px-3 py-3 font-medium text-slate-800">{{ $antrean->no_polisi }}</td>
                        <td class="px-3 py-3 text-slate-700">{{ $antrean->tipe_motor }}</td>
                        <td class="px-3 py-3 text-slate-700 whitespace-nowrap">
                            {{ $antrean->jam_masuk->format('H:i') }}
                            &ndash;
                            {{ $antrean->jam_selesai ? $antrean->jam_selesai->format('H:i') : '-' }}
                        </td>

                        {{-- Kolom Mekanik: dropdown assign, hanya aktif kalau punya permission --}}
                        <td class="px-3 py-3">
                            @if ($bisaAssign)
                                <select
                                    wire:change="assignMekanik({{ $antrean->id }}, $event.target.value)"
                                    class="rounded-lg border-slate-300 text-xs py-1.5 focus:ring-slate-800 focus:border-slate-800"
                                    @if ($antrean->status === 'selesai') disabled @endif>
                                    <option value="">- Belum ditugaskan -</option>
                                    @foreach ($mekanikAktif as $mekanik)
                                        <option value="{{ $mekanik->id }}" @selected($antrean->mekanik_id === $mekanik->id)>
                                            {{ $mekanik->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <span class="text-slate-700">{{ $antrean->mekanik->nama ?? '-' }}</span>
                            @endif
                        </td>

                        <td class="px-3 py-3 text-slate-700">{{ $antrean->jenisPekerjaan->nama_pekerjaan }}</td>
                        <td class="px-3 py-3 text-slate-700">{{ $antrean->no_hp ?: '-' }}</td>
                        <td class="px-3 py-3 text-center">
                            @if ($antrean->daya_auto)
                                <span class="inline-flex items-center justify-center w-5 h-5 rounded bg-emerald-100 text-emerald-600">✓</span>
                            @else
                                <span class="inline-flex items-center justify-center w-5 h-5 rounded bg-slate-100 text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-3 py-3">
                            <span @class([
                                'px-2.5 py-1 rounded-full text-xs font-semibold whitespace-nowrap',
                                'bg-amber-100 text-amber-700' => $antrean->status === 'menunggu',
                                'bg-blue-100 text-blue-700' => $antrean->status === 'dikerjakan',
                                'bg-emerald-100 text-emerald-700' => $antrean->status === 'selesai',
                            ])>
                                {{ $antrean->status_label }}
                            </span>
                        </td>
                        <td class="px-3 py-3 space-x-2 whitespace-nowrap">
                            @if ($bisaEdit && $antrean->status !== 'dikerjakan')
                                <button wire:click="edit({{ $antrean->id }})" class="text-blue-600 hover:text-blue-800 font-medium">Edit</button>
                            @endif
                            @if ($bisaPrint)
                                <a href="{{ route('antrean.print', $antrean->id) }}" target="_blank" class="text-slate-600 hover:text-slate-900 font-medium">Print</a>
                            @endif
                            @if ($bisaHapus)
                                <button wire:click="delete({{ $antrean->id }})"
                                    wire:confirm="Yakin ingin menghapus data antrean ini?"
                                    class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-10 text-center text-slate-400">
                            Belum ada konsumen yang terdaftar pada tanggal ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Tambah / Edit --}}
    @if ($showModal)
        <div class="fixed inset-0 bg-slate-900/50 flex items-center justify-center z-50 px-4"
             wire:click.self="closeModal">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">
                    {{ $editId ? 'Edit Data Antrean' : 'Daftarkan Konsumen Baru' }}
                </h2>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">No Polisi</label>
                        <input type="text" wire:model="no_polisi" placeholder="Contoh: F 1234 ABC"
                            class="w-full rounded-lg border-slate-300 text-sm uppercase focus:ring-slate-800 focus:border-slate-800">
                        @error('no_polisi') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tipe Motor</label>
                        <input type="text" wire:model="tipe_motor" placeholder="Contoh: Honda Beat"
                            class="w-full rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
                        @error('tipe_motor') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Jam Masuk</label>
                        <input type="time" wire:model="jam_masuk_waktu"
                            class="w-full rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
                        @error('jam_masuk_waktu') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        <p class="text-xs text-slate-400 mt-1">Jam selesai terisi otomatis saat mekanik klik "Selesai".</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Pekerjaan</label>
                        <select wire:model="jenis_pekerjaan_id"
                            class="w-full rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
                            <option value="">- Pilih -</option>
                            @foreach ($jenisPekerjaanAktif as $jp)
                                <option value="{{ $jp->id }}">{{ $jp->nama_pekerjaan }}</option>
                            @endforeach
                        </select>
                        @error('jenis_pekerjaan_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">No. HP</label>
                    <input type="text" wire:model="no_hp" placeholder="08xxxxxxxxxx"
                        class="w-full rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
                    @error('no_hp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6 flex items-center gap-2">
                    <input type="checkbox" wire:model="daya_auto" id="daya_auto"
                        class="rounded border-slate-300 text-slate-800 focus:ring-slate-800">
                    <label for="daya_auto" class="text-sm text-slate-700">Daya Auto</label>
                </div>

                <div class="flex justify-end gap-2">
                    <button wire:click="closeModal" class="px-4 py-2 rounded-lg text-sm text-slate-600 hover:bg-slate-100">
                        Batal
                    </button>
                    <button wire:click="save" class="px-4 py-2 rounded-lg text-sm bg-slate-900 text-white hover:bg-slate-800">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
