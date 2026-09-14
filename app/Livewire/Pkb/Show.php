<?php

namespace App\Livewire\Pkb;

use App\Models\Antrean;
use App\Models\Pkb;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public Antrean $antrean;
    public ?Pkb $pkb = null;

    public bool $setuju_1 = false;
    public bool $setuju_2 = false;

    // Diisi lewat JS (signature pad) sebelum simpanTandaTangan() dipanggil
    public string $tandaTanganBase64 = '';

    // Form khusus admin
    public string $no_pkb = '';

    public function mount(Antrean $antrean): void
    {
        $this->antrean = $antrean;
        $this->pkb = Pkb::where('antrean_id', $antrean->id)->first();

        if ($this->pkb) {
            $this->no_pkb = $this->pkb->no_pkb ?? '';
        }
    }

    /**
     * Konsumen centang persetujuan + tanda tangan di layar (biasanya
     * tablet/HP yang dipegangkan petugas entry), lalu petugas klik simpan.
     */
    public function simpanTandaTangan(): void
    {
        $this->validate([
            'setuju_1' => 'accepted',
            'setuju_2' => 'accepted',
            'tandaTanganBase64' => 'required|string|min:100', // pastikan bukan canvas kosong
        ], [
            'setuju_1.accepted' => 'Konsumen harus menyetujui poin nomor 1.',
            'setuju_2.accepted' => 'Konsumen harus menyetujui poin nomor 2.',
            'tandaTanganBase64.required' => 'Tanda tangan belum diisi.',
            'tandaTanganBase64.min' => 'Tanda tangan belum diisi, coba tanda tangan lagi.',
        ]);

        // Decode base64 PNG dari signature pad, simpan sebagai file
        $data = explode(',', $this->tandaTanganBase64);
        $binary = base64_decode(end($data));
        $filename = 'tanda-tangan/pkb-' . $this->antrean->id . '-' . Str::random(8) . '.png';
        Storage::disk('public')->put($filename, $binary);

        $this->pkb = Pkb::updateOrCreate(
            ['antrean_id' => $this->antrean->id],
            [
                'nama_konsumen' => $this->antrean->nama_konsumen,
                'setuju_1' => true,
                'setuju_2' => true,
                'tanda_tangan' => $filename,
                'ditandatangani_pada' => now(),
                'status' => 'menunggu_no_pkb',
                'created_by' => auth()->id(),
            ]
        );

        session()->flash('message', 'Formulir berhasil disimpan. Menunggu admin mengisi No. PKB/WO.');
    }

    /**
     * Admin mengisi No. PKB/WO resmi dari dokumen fisik yang dikeluarkan
     * PT Daya Adicipta Motora. Setelah ini, dokumen siap di-print/download.
     */
    public function simpanNoPkb(): void
    {
        if (! auth()->user()->can('isi no pkb')) {
            abort(403);
        }

        $this->validate([
            'no_pkb' => 'required|string|max:50',
        ]);

        $this->pkb->update([
            'no_pkb' => $this->no_pkb,
            'diisi_oleh' => auth()->id(),
            'diisi_pada' => now(),
            'status' => 'selesai',
        ]);

        session()->flash('message', 'No. PKB/WO berhasil disimpan. Dokumen siap dicetak.');
    }

    public function render()
    {
        return view('livewire.pkb.show', [
            'bisaIsiNoPkb' => auth()->user()->can('isi no pkb'),
        ]);
    }
}
