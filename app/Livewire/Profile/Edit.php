<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class Edit extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';

    // Foto baru yang mau diupload (belum tersimpan permanen sampai klik "Ganti Foto")
    public $fotoBaru = null;

    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    public function mount(): void
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
    }

    public function updateProfile(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore(auth()->id())],
        ]);

        auth()->user()->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        session()->flash('message', 'Profil berhasil diperbarui.');
    }

    public function uploadFoto(): void
    {
        $this->validate([
            'fotoBaru' => 'required|image|max:2048', // maksimal 2MB
        ]);

        $user = auth()->user();

        // Hapus foto lama dulu (kalau ada) supaya storage tidak numpuk file yatim
        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }

        // Disimpan di storage/app/public/foto-profil, bisa diakses lewat
        // /storage/foto-profil/xxx.jpg setelah `php artisan storage:link`
        $path = $this->fotoBaru->store('foto-profil', 'public');

        $user->update(['foto' => $path]);

        $this->fotoBaru = null;

        session()->flash('message', 'Foto profil berhasil diperbarui.');
    }

    public function hapusFoto(): void
    {
        $user = auth()->user();

        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
            $user->update(['foto' => null]);
        }

        session()->flash('message', 'Foto profil dihapus.');
    }

    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if (! Hash::check($this->current_password, auth()->user()->password)) {
            $this->addError('current_password', 'Password saat ini salah.');
            return;
        }

        auth()->user()->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        session()->flash('message', 'Password berhasil diganti.');
    }

    public function render()
    {
        return view('livewire.profile.edit');
    }
}
