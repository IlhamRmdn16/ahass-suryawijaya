<?php

namespace App\Livewire\JenisPekerjaan;

use App\Models\JenisPekerjaan;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public string $nama_pekerjaan = '';
    public bool $status_aktif = true;
    public ?int $editId = null;
    public bool $showModal = false;

    protected function rules(): array
    {
        return [
            'nama_pekerjaan' => 'required|string|max:255',
            'status_aktif' => 'boolean',
        ];
    }

    public function render()
    {
        return view('livewire.jenis-pekerjaan.index', [
            'jenisPekerjaans' => JenisPekerjaan::orderBy('nama_pekerjaan')->paginate(10),
        ]);
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $jp = JenisPekerjaan::findOrFail($id);

        $this->editId = $jp->id;
        $this->nama_pekerjaan = $jp->nama_pekerjaan;
        $this->status_aktif = $jp->status_aktif;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        JenisPekerjaan::updateOrCreate(
            ['id' => $this->editId],
            [
                'nama_pekerjaan' => $this->nama_pekerjaan,
                'status_aktif' => $this->status_aktif,
            ]
        );

        session()->flash('message', $this->editId
            ? 'Jenis pekerjaan berhasil diperbarui.'
            : 'Jenis pekerjaan baru berhasil ditambahkan.');

        $this->resetForm();
        $this->showModal = false;
    }

    public function toggleStatus(int $id): void
    {
        $jp = JenisPekerjaan::findOrFail($id);
        $jp->update(['status_aktif' => ! $jp->status_aktif]);
    }

    public function delete(int $id): void
    {
        $jp = JenisPekerjaan::findOrFail($id);

        if ($jp->antreans()->exists()) {
            session()->flash('error', 'Jenis pekerjaan ini sudah pernah dipakai di data antrean, tidak bisa dihapus. Nonaktifkan saja.');
            return;
        }

        $jp->delete();
        session()->flash('message', 'Jenis pekerjaan berhasil dihapus.');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset(['nama_pekerjaan', 'editId']);
        $this->status_aktif = true;
        $this->resetErrorBag();
    }
}
