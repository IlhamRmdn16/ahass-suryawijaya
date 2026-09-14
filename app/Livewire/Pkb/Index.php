<?php

namespace App\Livewire\Pkb;

use App\Models\Antrean;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public string $tanggal;

    public function mount(): void
    {
        $this->tanggal = now()->format('Y-m-d');
    }

    public function render()
    {
        $antreans = Antrean::with('pkb')
            ->tanggal($this->tanggal)
            ->orderBy('jam_masuk')
            ->get();

        return view('livewire.pkb.index', [
            'antreans' => $antreans,
            'bisaIsiNoPkb' => auth()->user()->can('isi no pkb'),
        ]);
    }
}
