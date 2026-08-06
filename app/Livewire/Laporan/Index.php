<?php

namespace App\Livewire\Laporan;

use App\Models\Antrean;
use App\Models\Mekanik;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public string $tanggal_awal;
    public string $tanggal_akhir;
    public string $filterStatus = 'semua';
    public string $filterMekanik = 'semua';

    // Tanggal khusus untuk cetak Unit Entry A4 -- terpisah dari filter
    // rentang di atas, defaultnya hari ini, bisa diubah bebas.
    public string $tanggalPrint;

    public function mount(): void
    {
        // Default: rentang bulan berjalan
        $this->tanggal_awal = now()->startOfMonth()->format('Y-m-d');
        $this->tanggal_akhir = now()->endOfMonth()->format('Y-m-d');
        $this->tanggalPrint = now()->format('Y-m-d');
    }

    public function updated($property): void
    {
        if (in_array($property, ['tanggal_awal', 'tanggal_akhir', 'filterStatus', 'filterMekanik'])) {
            $this->resetPage();
        }
    }

    private function baseQuery()
    {
        $query = Antrean::with(['mekanik', 'jenisPekerjaan'])
            ->whereBetween('tanggal', [$this->tanggal_awal, $this->tanggal_akhir]);

        if ($this->filterStatus !== 'semua') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterMekanik !== 'semua') {
            $query->where('mekanik_id', $this->filterMekanik);
        }

        return $query;
    }

    public function render()
    {
        $antreans = $this->baseQuery()->orderByDesc('tanggal')->orderByDesc('jam_masuk')->paginate(15);

        // Ringkasan keseluruhan (tidak kena filter status/mekanik, murni rentang tanggal)
        $semuaDalamRentang = Antrean::whereBetween('tanggal', [$this->tanggal_awal, $this->tanggal_akhir]);

        $totalMasuk = (clone $semuaDalamRentang)->count();
        $totalSelesai = (clone $semuaDalamRentang)->where('status', 'selesai')->count();
        $totalDikerjakan = (clone $semuaDalamRentang)->where('status', 'dikerjakan')->count();
        $totalMenunggu = (clone $semuaDalamRentang)->where('status', 'menunggu')->count();

        // Rekap per mekanik: jumlah selesai + rata-rata durasi pengerjaan (menit)
        $rekapMekanik = Mekanik::query()
            ->withCount(['antreans as total_selesai' => function ($q) {
                $q->whereBetween('tanggal', [$this->tanggal_awal, $this->tanggal_akhir])
                    ->where('status', 'selesai');
            }])
            ->get()
            ->map(function ($mekanik) {
                $rataRata = Antrean::where('mekanik_id', $mekanik->id)
                    ->whereBetween('tanggal', [$this->tanggal_awal, $this->tanggal_akhir])
                    ->where('status', 'selesai')
                    ->whereNotNull('jam_selesai')
                    ->get()
                    ->avg(fn ($a) => $a->jam_masuk->diffInMinutes($a->jam_selesai));

                $mekanik->rata_rata_menit = $rataRata ? round($rataRata) : null;

                return $mekanik;
            })
            ->sortByDesc('total_selesai')
            ->values();

        return view('livewire.laporan.index', [
            'antreans' => $antreans,
            'totalMasuk' => $totalMasuk,
            'totalSelesai' => $totalSelesai,
            'totalDikerjakan' => $totalDikerjakan,
            'totalMenunggu' => $totalMenunggu,
            'rekapMekanik' => $rekapMekanik,
            'daftarMekanik' => Mekanik::orderBy('nama')->get(),
        ]);
    }
}
