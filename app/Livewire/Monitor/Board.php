<?php

namespace App\Livewire\Monitor;

use App\Models\Mekanik;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.monitor')]
class Board extends Component
{
    public function render()
    {
        $mekaniks = Mekanik::aktif()
            ->with(['antreanAktif.jenisPekerjaan'])
            ->orderBy('nama')
            ->get();

        $jumlahMenunggu = \App\Models\Antrean::whereDate('tanggal', now()->format('Y-m-d'))
            ->where('status', 'menunggu')
            ->count();

        return view('livewire.monitor.board', [
            'mekaniks' => $mekaniks,
            'jumlahMenunggu' => $jumlahMenunggu,
        ]);
    }
}
