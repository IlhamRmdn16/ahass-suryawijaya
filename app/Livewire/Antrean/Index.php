<?php

namespace App\Livewire\Antrean;

use App\Models\Antrean;
use App\Models\JenisPekerjaan;
use App\Models\Mekanik;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    // Filter tanggal di bagian atas halaman, default hari ini
    public string $tanggal;

    // Form tambah/edit antrean -- JP SENGAJA TIDAK ADA di sini lagi,
    // karena sekarang JP diisi admin lewat dropdown di tabel, bukan
    // saat entry mendaftarkan konsumen.
    public ?int $editId = null;
    public string $no_polisi = '';
    public string $tipe_motor = '';
    public string $jam_masuk_waktu = ''; // hanya jam (HH:mm), digabung dengan $tanggal saat simpan
    public string $no_hp = '';
    public bool $daya_auto = true;

    public bool $showModal = false;

    public function mount(): void
    {
        $this->tanggal = now()->format('Y-m-d');
        $this->jam_masuk_waktu = now()->format('H:i');
    }

    protected function rules(): array
    {
        return [
            'no_polisi' => 'required|string|max:20',
            'tipe_motor' => 'required|string|max:100',
            'jam_masuk_waktu' => 'required',
            'no_hp' => 'nullable|string|max:20',
            'daya_auto' => 'boolean',
        ];
    }

    public function render()
    {
        $antreans = Antrean::with(['mekanik', 'jenisPekerjaan'])
            ->tanggal($this->tanggal)
            ->orderBy('jam_masuk')
            ->get();

        return view('livewire.antrean.index', [
            'antreans' => $antreans,
            'mekanikAktif' => Mekanik::aktif()->orderBy('nama')->get(),
            'jenisPekerjaanAktif' => JenisPekerjaan::aktif()->orderBy('nama_pekerjaan')->get(),
            // permission ini menentukan tombol/dropdown mana yang muncul di view
            'bisaAssign' => auth()->user()->can('assign antrean'),
            'bisaEdit' => auth()->user()->can('edit antrean'),
            'bisaHapus' => auth()->user()->can('delete antrean'),
            'bisaPrint' => auth()->user()->can('print antrean'),
            'bisaSelesaikanManual' => auth()->user()->can('selesaikan antrean'),
        ]);
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $antrean = Antrean::findOrFail($id);

        $this->editId = $antrean->id;
        $this->no_polisi = $antrean->no_polisi;
        $this->tipe_motor = $antrean->tipe_motor;
        $this->jam_masuk_waktu = $antrean->jam_masuk->format('H:i');
        $this->no_hp = $antrean->no_hp ?? '';
        $this->daya_auto = $antrean->daya_auto;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $jamMasuk = Carbon::parse($this->tanggal . ' ' . $this->jam_masuk_waktu);

        if ($this->editId) {
            Antrean::findOrFail($this->editId)->update([
                'no_polisi' => $this->no_polisi,
                'tipe_motor' => $this->tipe_motor,
                'jam_masuk' => $jamMasuk,
                'no_hp' => $this->no_hp,
                'daya_auto' => $this->daya_auto,
            ]);
            session()->flash('message', 'Data antrean berhasil diperbarui.');
        } else {
            Antrean::create([
                'tanggal' => $this->tanggal,
                'no_polisi' => strtoupper($this->no_polisi),
                'tipe_motor' => $this->tipe_motor,
                'jam_masuk' => $jamMasuk,
                'no_hp' => $this->no_hp,
                'daya_auto' => $this->daya_auto,
                'status' => 'menunggu',
                'created_by' => auth()->id(),
                // jenis_pekerjaan_id sengaja dikosongkan -- diisi admin belakangan
            ]);
            session()->flash('message', 'Konsumen baru berhasil didaftarkan ke antrean.');
        }

        $this->resetForm();
        $this->showModal = false;
    }

    /**
     * Admin/Super Admin "mendorong" antrean ke mekanik tertentu.
     * Ini satu-satunya cara mekanik_id terisi -- mekanik tidak bisa
     * memilih sendiri.
     */
    public function assignMekanik(int $antreanId, $mekanikId): void
    {
        if (! auth()->user()->can('assign antrean')) {
            abort(403);
        }

        $antrean = Antrean::findOrFail($antreanId);

        if ($mekanikId === '' || $mekanikId === null) {
            // Admin mengosongkan assignment (batal assign)
            $antrean->update([
                'mekanik_id' => null,
                'assigned_by' => null,
                'status' => 'menunggu',
            ]);
            return;
        }

        $antrean->update([
            'mekanik_id' => $mekanikId,
            'assigned_by' => auth()->id(),
            'status' => 'dikerjakan',
        ]);

        session()->flash('message', 'Antrean berhasil didorong ke mekanik.');
    }

    /**
     * Admin memilihkan Jenis Pekerjaan untuk satu antrean.
     * Sengaja terpisah dari form entry -- entry TIDAK punya akses
     * mengubah ini, cuma admin (permission 'assign antrean').
     */
    public function assignJenisPekerjaan(int $antreanId, $jenisPekerjaanId): void
    {
        if (! auth()->user()->can('assign antrean')) {
            abort(403);
        }

        $antrean = Antrean::findOrFail($antreanId);

        $antrean->update([
            'jenis_pekerjaan_id' => $jenisPekerjaanId === '' ? null : $jenisPekerjaanId,
        ]);

        session()->flash('message', 'Jenis pekerjaan berhasil diperbarui.');
    }

    /**
     * Admin menyelesaikan pekerjaan ATAS NAMA mekanik -- buat jaga-jaga
     * kalau mekanik lupa klik "Selesai" sendiri dari dashboardnya.
     * Efeknya sama persis: jam_selesai terisi now(), status jadi selesai.
     */
    public function selesaikanManual(int $antreanId): void
    {
        if (! auth()->user()->can('selesaikan antrean')) {
            abort(403);
        }

        $antrean = Antrean::findOrFail($antreanId);

        if ($antrean->status !== 'dikerjakan') {
            session()->flash('error', 'Antrean ini belum dalam status dikerjakan.');
            return;
        }

        $antrean->update([
            'jam_selesai' => now(),
            'status' => 'selesai',
        ]);

        session()->flash('message', 'Antrean ' . $antrean->no_polisi . ' ditandai selesai oleh admin.');
    }

    public function delete(int $id): void
    {
        $antrean = Antrean::findOrFail($id);

        if ($antrean->status === 'dikerjakan') {
            session()->flash('error', 'Antrean sedang dikerjakan mekanik, tidak bisa dihapus.');
            return;
        }

        $antrean->delete();
        session()->flash('message', 'Data antrean berhasil dihapus.');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset(['editId', 'no_polisi', 'tipe_motor', 'no_hp']);
        $this->jam_masuk_waktu = now()->format('H:i');
        $this->daya_auto = true;
        $this->resetErrorBag();
    }
}
