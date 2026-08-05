<div class="max-w-xl">
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Profil Saya</h1>
        <p class="text-sm text-slate-500">Kelola informasi akun dan password kamu.</p>
    </div>

    @if (session('message'))
        <div class="mb-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm">
            {{ session('message') }}
        </div>
    @endif

    {{-- Form Data Diri --}}
    <div class="bg-white border border-slate-200 rounded-xl p-6 mb-6">
        <h2 class="text-sm font-semibold text-slate-700 mb-4">Informasi Akun</h2>

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

        <button wire:click="updateProfile"
            class="px-4 py-2 rounded-lg text-sm bg-slate-900 text-white hover:bg-slate-800">
            Simpan Perubahan
        </button>
    </div>

    {{-- Form Ganti Password --}}
    <div class="bg-white border border-slate-200 rounded-xl p-6">
        <h2 class="text-sm font-semibold text-slate-700 mb-4">Ganti Password</h2>

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-1">Password Saat Ini</label>
            <input type="password" wire:model="current_password"
                class="w-full rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
            @error('current_password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
            <input type="password" wire:model="new_password"
                class="w-full rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
            @error('new_password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password Baru</label>
            <input type="password" wire:model="new_password_confirmation"
                class="w-full rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
        </div>

        <button wire:click="updatePassword"
            class="px-4 py-2 rounded-lg text-sm bg-slate-900 text-white hover:bg-slate-800">
            Ganti Password
        </button>
    </div>
</div>
