<?php

namespace App\Livewire\Mekanik;

use App\Models\Antrean;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $mekanikId = auth()->user()->mekanik_id;

        $tugasAktif = Antrean::with('jenisPekerjaan')
            ->where('mekanik_id', $mekanikId)
            ->where('status', 'dikerjakan')
            ->orderBy('jam_masuk')
            ->get();

        $riwayatHariIni = Antrean::with('jenisPekerjaan')
            ->where('mekanik_id', $mekanikId)
            ->where('status', 'selesai')
            ->whereDate('tanggal', now()->format('Y-m-d'))
            ->orderByDesc('jam_selesai')
            ->get();

        return view('livewire.mekanik.dashboard', [
            'tugasAktif' => $tugasAktif,
            'riwayatHariIni' => $riwayatHariIni,
        ]);
    }

    /**
     * Mekanik klik "Selesai". jam_selesai terisi otomatis = waktu sekarang.
     * Ada pengecekan keamanan: mekanik cuma bisa selesaikan tugas yang
     * memang di-assign ke dirinya sendiri.
     */
    public function selesaikan(int $antreanId): void
    {
        $antrean = Antrean::findOrFail($antreanId);

        if ($antrean->mekanik_id !== auth()->user()->mekanik_id) {
            abort(403, 'Ini bukan tugas kamu.');
        }

        $antrean->update([
            'jam_selesai' => now(),
            'status' => 'selesai',
        ]);

        session()->flash('message', 'Pekerjaan ' . $antrean->no_polisi . ' ditandai selesai.');
    }
}
