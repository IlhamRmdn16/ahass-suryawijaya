<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Jenis Pekerjaan</h1>
            <p class="text-sm text-slate-500">Master data jenis pekerjaan yang muncul di dropdown form entry.</p>
        </div>
        <button wire:click="create"
            class="inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Jenis Pekerjaan
        </button>
    </div>

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

    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide w-16">No</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Nama Pekerjaan</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($jenisPekerjaans as $i => $jp)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $jenisPekerjaans->firstItem() + $i }}</td>
                        <td class="px-4 py-3 text-sm font-medium text-slate-800">{{ $jp->nama_pekerjaan }}</td>
                        <td class="px-4 py-3 text-sm">
                            <button wire:click="toggleStatus({{ $jp->id }})"
                                class="px-2.5 py-1 rounded-full text-xs font-semibold transition
                                {{ $jp->status_aktif
                                    ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200'
                                    : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                                {{ $jp->status_aktif ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </td>
                        <td class="px-4 py-3 text-sm space-x-3">
                            <button wire:click="edit({{ $jp->id }})" class="text-blue-600 hover:text-blue-800 font-medium">Edit</button>
                            <button wire:click="delete({{ $jp->id }})"
                                wire:confirm="Yakin ingin menghapus jenis pekerjaan ini?"
                                class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-10 text-center text-sm text-slate-400">
                            Belum ada data jenis pekerjaan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $jenisPekerjaans->links() }}
    </div>

    @if ($showModal)
        <div class="fixed inset-0 bg-slate-900/50 flex items-center justify-center z-50 px-4"
             wire:click.self="closeModal">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">
                    {{ $editId ? 'Edit Jenis Pekerjaan' : 'Tambah Jenis Pekerjaan' }}
                </h2>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Pekerjaan</label>
                    <input type="text" wire:model="nama_pekerjaan" placeholder="Contoh: Ganti Oli"
                        class="w-full rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
                    @error('nama_pekerjaan')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6 flex items-center gap-2">
                    <input type="checkbox" wire:model="status_aktif" id="status_aktif"
                        class="rounded border-slate-300 text-slate-800 focus:ring-slate-800">
                    <label for="status_aktif" class="text-sm text-slate-700">Aktif (tampil di dropdown entry)</label>
                </div>

                <div class="flex justify-end gap-2">
                    <button wire:click="closeModal"
                        class="px-4 py-2 rounded-lg text-sm text-slate-600 hover:bg-slate-100">
                        Batal
                    </button>
                    <button wire:click="save"
                        class="px-4 py-2 rounded-lg text-sm bg-slate-900 text-white hover:bg-slate-800">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
