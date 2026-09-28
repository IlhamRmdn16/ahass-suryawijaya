<div wire:poll.10s.visible x-data="{ open: $wire.entangle('showModal') }">

    {{-- Header + filter tanggal --}}
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Antrean Konsumen</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar konsumen yang masuk pada tanggal terpilih.</p>
        </div>

        <div class="flex items-end gap-3">
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Tanggal</label>
                <input type="date" wire:model.live="tanggal"
                    class="rounded-xl border-slate-300 bg-white text-sm shadow-sm focus:ring-red-500 focus:border-red-500">
            </div>
            <button type="button"
                @click="open = true; $wire.$set('jam_masuk_waktu', new Date().toTimeString().slice(0, 5), false)"
                class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-red-500/25 transition whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Konsumen Baru
            </button>
        </div>
    </div>

    {{-- Kartu ringkasan (untuk seluruh data di tanggal ini, bukan cuma halaman aktif) --}}
    @php
        $nMenunggu = $ringkasan['menunggu'] ?? 0;
        $nDikerjakan = $ringkasan['dikerjakan'] ?? 0;
        $nSelesai = $ringkasan['selesai'] ?? 0;
        $nTotal = $nMenunggu + $nDikerjakan + $nSelesai;
    @endphp
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-slate-400 shadow-sm px-4 py-3.5">
            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Total Masuk</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $nTotal }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-amber-400 shadow-sm px-4 py-3.5">
            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Menunggu</p>
            <p class="text-2xl font-bold text-amber-600 mt-1">{{ $nMenunggu }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-blue-500 shadow-sm px-4 py-3.5">
            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Dikerjakan</p>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $nDikerjakan }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-emerald-500 shadow-sm px-4 py-3.5">
            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Selesai</p>
            <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $nSelesai }}</p>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if (session('message'))
        <div class="mb-4 flex items-center gap-2.5 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
            <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('message') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 flex items-center gap-2.5 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
            <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">No Polisi</th>
                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tipe Motor</th>
                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Jam</th>
                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Mekanik</th>
                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">JP</th>
                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">No. HP</th>
                        <th class="px-4 py-3 text-center text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Daya Auto</th>
                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($antreans as $i => $antrean)
                        <tr class="hover:bg-red-50/40 transition-colors">
                            <td class="px-4 py-3.5 text-slate-400 font-medium">{{ $antreans->firstItem() + $i }}</td>
                            <td class="px-4 py-3.5 font-medium text-slate-800">{{ $antrean->nama_konsumen ?: '-' }}</td>
                            <td class="px-4 py-3.5">
                                <span class="inline-block px-2.5 py-1 rounded-md border border-slate-300 bg-white text-slate-900 font-bold tracking-wider text-xs shadow-sm">
                                    {{ $antrean->no_polisi }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600">{{ $antrean->tipe_motor }}</td>
                            <td class="px-4 py-3.5 text-slate-600 whitespace-nowrap tabular-nums">
                                {{ $antrean->jam_masuk->format('H:i') }}
                                <span class="text-slate-300 mx-0.5">&ndash;</span>
                                {{ $antrean->jam_selesai ? $antrean->jam_selesai->format('H:i') : '-' }}
                            </td>

                            {{-- Mekanik: dropdown assign untuk admin, teks biasa untuk yang lain --}}
                            <td class="px-4 py-3.5">
                                @if ($bisaAssign)
                                    <select
                                        wire:change="assignMekanik({{ $antrean->id }}, $event.target.value)"
                                        class="min-w-[9.5rem] rounded-lg border-slate-200 bg-white text-xs py-1.5 shadow-sm focus:ring-red-500 focus:border-red-500 disabled:bg-slate-50 disabled:text-slate-400"
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

                            {{-- JP: dropdown assign untuk admin --}}
                            <td class="px-4 py-3.5">
                                @if ($bisaAssign)
                                    <select
                                        wire:change="assignJenisPekerjaan({{ $antrean->id }}, $event.target.value)"
                                        class="min-w-[9.5rem] rounded-lg border-slate-200 bg-white text-xs py-1.5 shadow-sm focus:ring-red-500 focus:border-red-500 disabled:bg-slate-50 disabled:text-slate-400"
                                        @if ($antrean->status === 'selesai') disabled @endif>
                                        <option value="">- Belum ditentukan -</option>
                                        @foreach ($jenisPekerjaanAktif as $jp)
                                            <option value="{{ $jp->id }}" @selected($antrean->jenis_pekerjaan_id === $jp->id)>
                                                {{ $jp->nama_pekerjaan }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <span class="text-slate-700">{{ $antrean->jenisPekerjaan->nama_pekerjaan ?? '-' }}</span>
                                @endif
                            </td>

                            <td class="px-4 py-3.5 text-slate-600 whitespace-nowrap">{{ $antrean->no_hp ?: '-' }}</td>

                            <td class="px-4 py-3.5 text-center">
                                @if ($antrean->daya_auto)
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-600">
                                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 text-slate-400 text-xs">&ndash;</span>
                                @endif
                            </td>

                            <td class="px-4 py-3.5">
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

                            <td class="px-4 py-3.5 whitespace-nowrap">
                                <div class="flex items-center gap-1">
                                    @if ($bisaSelesaikanManual && $antrean->status === 'dikerjakan')
                                        <button wire:click="selesaikanManual({{ $antrean->id }})"
                                            wire:confirm="Tandai antrean {{ $antrean->no_polisi }} sebagai selesai? Biasanya ini dilakukan mekanik sendiri, cuma pakai ini kalau mekanik lupa klik selesai."
                                            wire:loading.attr="disabled" wire:target="selesaikanManual({{ $antrean->id }})"
                                            class="disabled:opacity-40 px-2.5 py-1 rounded-lg text-xs font-semibold text-emerald-700 hover:bg-emerald-50 transition">Selesai</button>
                                    @endif
                                    @if ($bisaEdit && $antrean->status !== 'dikerjakan')
                                        <button wire:click="edit({{ $antrean->id }})"
                                            wire:loading.attr="disabled" wire:target="edit({{ $antrean->id }})"
                                            class="disabled:opacity-40 px-2.5 py-1 rounded-lg text-xs font-semibold text-blue-700 hover:bg-blue-50 transition">Edit</button>
                                    @endif
                                    @if ($bisaPrint)
                                        <a href="{{ route('antrean.print', $antrean->id) }}" target="_blank"
                                            class="px-2.5 py-1 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">Print</a>
                                    @endif
                                    @if ($bisaHapus)
                                        <button wire:click="delete({{ $antrean->id }})"
                                            wire:confirm="Yakin ingin menghapus data antrean ini?"
                                            wire:loading.attr="disabled" wire:target="delete({{ $antrean->id }})"
                                            class="disabled:opacity-40 px-2.5 py-1 rounded-lg text-xs font-semibold text-red-600 hover:bg-red-50 transition">Hapus</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-4 py-16 text-center">
                                <div class="mx-auto w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-600">Belum ada konsumen</p>
                                <p class="text-xs text-slate-400 mt-1">Belum ada konsumen yang terdaftar pada tanggal ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer tabel: jumlah baris per halaman + info + paginasi --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-3 px-4 py-3 border-t border-slate-100 bg-slate-50/60">
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

    {{-- Indikator proses: muncul untuk aksi pengguna (bukan polling otomatis) --}}
    <div wire:loading.flex
         wire:target="save, edit, delete, selesaikanManual, assignMekanik, assignJenisPekerjaan"
         class="fixed bottom-5 right-5 z-[70] items-center gap-2.5 px-4 py-2.5 rounded-full bg-slate-900 text-white text-xs font-medium shadow-2xl">
        <svg class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        Memproses...
    </div>

    {{-- Modal tambah / edit --}}
    <div x-show="open" x-cloak
         x-transition.opacity.duration.150ms
         @keydown.escape.window="if (open) { open = false; $wire.closeModal() }"
         class="fixed inset-0 bg-slate-950/50 backdrop-blur-sm flex items-center justify-center z-50 px-4"
         @click.self="open = false; $wire.closeModal()">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">

                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <h2 class="text-lg font-semibold text-slate-900">
                        {{ $editId ? 'Edit Data Antrean' : 'Daftarkan Konsumen Baru' }}
                    </h2>
                    <button type="button" @click="open = false; $wire.closeModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="px-6 py-5">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Konsumen</label>
                        <input type="text" wire:model="nama_konsumen" placeholder="Contoh: Budi Santoso"
                            class="w-full rounded-xl border-slate-300 text-sm focus:ring-red-500 focus:border-red-500">
                        @error('nama_konsumen') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        <p class="text-xs text-slate-400 mt-1">Hanya buat data internal, tidak muncul di struk cetak.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">No Polisi</label>
                            <input type="text" wire:model="no_polisi" placeholder="Contoh: Z 1234 ABC"
                                class="w-full rounded-xl border-slate-300 text-sm uppercase focus:ring-red-500 focus:border-red-500">
                            @error('no_polisi') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Tipe Motor</label>
                            <input type="text" wire:model="tipe_motor" placeholder="Contoh: Beat CBS"
                                class="w-full rounded-xl border-slate-300 text-sm focus:ring-red-500 focus:border-red-500">
                            @error('tipe_motor') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Jam Masuk</label>
                            <input type="time" wire:model="jam_masuk_waktu"
                                class="w-full rounded-xl border-slate-300 text-sm focus:ring-red-500 focus:border-red-500">
                            @error('jam_masuk_waktu') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">No. HP</label>
                            <input type="text" wire:model="no_hp" placeholder="08xxxxxxxxxx"
                                class="w-full rounded-xl border-slate-300 text-sm focus:ring-red-500 focus:border-red-500">
                            @error('no_hp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 -mt-2 mb-4">Jam selesai terisi otomatis saat mekanik/admin klik "Selesai".</p>

                    <label for="daya_auto" class="flex items-center gap-2.5 mb-5 cursor-pointer">
                        <input type="checkbox" wire:model="daya_auto" id="daya_auto"
                            class="rounded border-slate-300 text-red-600 focus:ring-red-500">
                        <span class="text-sm text-slate-700">Daya Auto</span>
                    </label>

                    <p class="text-xs text-slate-500 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5">
                        Jenis Pekerjaan dan Mekanik akan ditentukan oleh admin lewat tabel setelah konsumen ini terdaftar.
                    </p>
                </div>

                <div class="flex justify-end gap-2 px-6 py-4 border-t border-slate-100 bg-slate-50/60 rounded-b-2xl">
                    <button type="button" @click="open = false; $wire.closeModal()" class="px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-100 transition">
                        Batal
                    </button>
                    <button wire:click="save"
                        wire:loading.attr="disabled" wire:target="save"
                        class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 shadow-lg shadow-red-500/25 transition disabled:opacity-60 disabled:cursor-wait">
                        <span wire:loading.remove wire:target="save">Simpan</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>
            </div>
    </div>
</div>
