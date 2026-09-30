<?php

namespace App\Livewire\Monitor;

use App\Models\Antrean;
use App\Models\Mekanik;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.monitor')]
class Board extends Component
{
    public array $diumumkanIds = [];

    public function render()
    {
        $mekaniks = Mekanik::aktif()
            ->with(['antreanAktif.jenisPekerjaan', 'user'])
            ->orderBy('nama')
            ->get();

        $jumlahMenunggu = Antrean::whereDate('tanggal', now()->format('Y-m-d'))
            ->where('status', 'menunggu')
            ->count();

        $baruSelesai = Antrean::with('mekanik')
            ->whereDate('tanggal', now()->format('Y-m-d'))
            ->where('status', 'selesai')
            ->whereNotNull('jam_selesai')
            ->where('jam_selesai', '>=', now()->subMinutes(2))
            ->whereNotIn('id', $this->diumumkanIds)
            ->orderBy('jam_selesai')
            ->get();

        foreach ($baruSelesai as $antrean) {
            $this->diumumkanIds[] = $antrean->id;

            $this->dispatch('antrean-selesai',
                noPolisi: $antrean->no_polisi,
                mekanik: $antrean->mekanik->nama ?? '-',
            );
        }

        if (count($this->diumumkanIds) > 200) {
            $this->diumumkanIds = array_slice($this->diumumkanIds, -200);
        }

        return view('livewire.monitor.board', [
            'mekaniks' => $mekaniks,
            'jumlahMenunggu' => $jumlahMenunggu,
        ]);
    }
}
