<?php

namespace App\Livewire\Users;

use App\Models\Mekanik;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public ?int $editId = null;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = '';
    public ?int $mekanik_id = null;

    public bool $showModal = false;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->editId)],
            'password' => $this->editId ? 'nullable|string|min:6' : 'required|string|min:6',
            'role' => 'required|in:super admin,entry,mekanik,viewer',
            'mekanik_id' => 'required_if:role,mekanik|nullable|exists:mekaniks,id',
        ];
    }

    public function render()
    {
        return view('livewire.users.index', [
            'users' => User::with('roles', 'mekanik')->orderBy('name')->paginate(10),
            // Mekanik yang belum punya akun sama sekali, ATAU mekanik yang sedang dipilih saat edit
            'mekanikTersedia' => Mekanik::whereDoesntHave('user')
                ->orWhere('id', $this->mekanik_id)
                ->orderBy('nama')
                ->get(),
        ]);
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $user = User::findOrFail($id);

        $this->editId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->role = $user->getRoleNames()->first() ?? '';
        $this->mekanik_id = $user->mekanik_id;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        if ($this->editId) {
            $user = User::findOrFail($this->editId);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'mekanik_id' => $this->role === 'mekanik' ? $this->mekanik_id : null,
                ...($this->password ? ['password' => Hash::make($this->password)] : []),
            ]);
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'mekanik_id' => $this->role === 'mekanik' ? $this->mekanik_id : null,
                'email_verified_at' => now(),
            ]);
        }

        $user->syncRoles([$this->role]);

        session()->flash('message', $this->editId ? 'Akun berhasil diperbarui.' : 'Akun baru berhasil dibuat.');

        $this->resetForm();
        $this->showModal = false;
    }

    public function delete(int $id): void
    {
        if ($id === auth()->id()) {
            session()->flash('error', 'Kamu tidak bisa menghapus akun sendiri.');
            return;
        }

        User::findOrFail($id)->delete();
        session()->flash('message', 'Akun berhasil dihapus.');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset(['editId', 'name', 'email', 'password', 'role', 'mekanik_id']);
        $this->resetErrorBag();
    }
}
