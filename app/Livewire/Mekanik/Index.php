<?php

namespace App\Livewire\Mekanik;

use App\Models\Mekanik;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public string $nama = '';
    public bool $status_aktif = true;
    public ?int $editId = null;
    public bool $showModal = false;

    protected function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'status_aktif' => 'boolean',
        ];
    }

    public function render()
    {
        return view('livewire.mekanik.index', [
            'mekaniks' => Mekanik::orderBy('nama')->paginate(10),
        ]);
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $mekanik = Mekanik::findOrFail($id);

        $this->editId = $mekanik->id;
        $this->nama = $mekanik->nama;
        $this->status_aktif = $mekanik->status_aktif;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        Mekanik::updateOrCreate(
            ['id' => $this->editId],
            [
                'nama' => $this->nama,
                'status_aktif' => $this->status_aktif,
            ]
        );

        session()->flash('message', $this->editId
            ? 'Data mekanik berhasil diperbarui.'
            : 'Mekanik baru berhasil ditambahkan.');

        $this->resetForm();
        $this->showModal = false;
    }

    public function toggleStatus(int $id): void
    {
        $mekanik = Mekanik::findOrFail($id);
        $mekanik->update(['status_aktif' => ! $mekanik->status_aktif]);
    }

    public function delete(int $id): void
    {
        // Cegah hapus mekanik yang masih punya antrean aktif
        $mekanik = Mekanik::findOrFail($id);

        if ($mekanik->antreans()->where('status', 'dikerjakan')->exists()) {
            session()->flash('error', 'Mekanik ini masih punya pekerjaan aktif, tidak bisa dihapus.');
            return;
        }

        $mekanik->delete();
        session()->flash('message', 'Mekanik berhasil dihapus.');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset(['nama', 'editId']);
        $this->status_aktif = true;
        $this->resetErrorBag();
    }
}
