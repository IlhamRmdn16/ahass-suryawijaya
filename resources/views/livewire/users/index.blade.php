<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Pengguna & Role</h1>
            <p class="text-sm text-slate-500">Kelola akun login dan hak akses (super admin, entry, mekanik, viewer).</p>
        </div>
        <button wire:click="create"
            class="inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Pengguna
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
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Role</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Terhubung Mekanik</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($users as $user)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <span @class([
                                'px-2.5 py-1 rounded-full text-xs font-semibold whitespace-nowrap',
                                'bg-red-100 text-red-700' => $user->hasRole('super admin'),
                                'bg-blue-100 text-blue-700' => $user->hasRole('entry'),
                                'bg-purple-100 text-purple-700' => $user->hasRole('mekanik'),
                                'bg-slate-100 text-slate-600' => $user->hasRole('viewer'),
                            ])>
                                {{ $user->getRoleNames()->first() ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $user->mekanik->nama ?? '-' }}</td>
                        <td class="px-4 py-3 space-x-3">
                            <button wire:click="edit({{ $user->id }})" class="text-blue-600 hover:text-blue-800 font-medium">Edit</button>
                            @if ($user->id !== auth()->id())
                                <button wire:click="delete({{ $user->id }})"
                                    wire:confirm="Yakin ingin menghapus akun {{ $user->name }}?"
                                    class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-slate-400">Belum ada pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

    {{-- Modal Tambah / Edit --}}
    @if ($showModal)
        <div class="fixed inset-0 bg-slate-900/50 flex items-center justify-center z-50 px-4"
             wire:click.self="closeModal">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 max-h-[90vh] overflow-y-auto">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">
                    {{ $editId ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}
                </h2>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama</label>
                    <input type="text" wire:model="name"
                        class="w-full rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" wire:model="email"
                        class="w-full rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
                    @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Password {{ $editId ? '(kosongkan kalau tidak ganti)' : '' }}
                    </label>
                    <input type="password" wire:model="password"
                        class="w-full rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
                    @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Role</label>
                    <select wire:model.live="role"
                        class="w-full rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
                        <option value="">- Pilih Role -</option>
                        <option value="super admin">Super Admin</option>
                        <option value="entry">Entry</option>
                        <option value="mekanik">Mekanik</option>
                        <option value="viewer">Viewer</option>
                    </select>
                    @error('role') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                @if ($role === 'mekanik')
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Hubungkan ke Data Mekanik</label>
                        <select wire:model="mekanik_id"
                            class="w-full rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
                            <option value="">- Pilih Mekanik -</option>
                            @foreach ($mekanikTersedia as $mekanik)
                                <option value="{{ $mekanik->id }}">{{ $mekanik->nama }}</option>
                            @endforeach
                        </select>
                        @error('mekanik_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        <p class="text-xs text-slate-400 mt-1">
                            Kalau belum ada di daftar, tambahkan dulu di menu Data Mekanik.
                        </p>
                    </div>
                @endif

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
