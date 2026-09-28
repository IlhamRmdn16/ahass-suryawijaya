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

    public const PER_PAGE_OPTIONS = [10, 20, 50, 100];

    public string $tanggal_awal;
    public string $tanggal_akhir;
    public string $filterStatus = 'semua';
    public string $filterMekanik = 'semua';

    // Tanggal khusus cetak Unit Entry A4 (terpisah dari filter rentang)
    public string $tanggalPrint;

    // Jumlah baris per halaman di tabel Detail Antrean
    public $perPage = 10;

    public function mount(): void
    {
        $this->tanggal_awal = now()->startOfMonth()->format('Y-m-d');
        $this->tanggal_akhir = now()->endOfMonth()->format('Y-m-d');
        $this->tanggalPrint = now()->format('Y-m-d');
    }

    public function updated($property): void
    {
        if (in_array($property, ['tanggal_awal', 'tanggal_akhir', 'filterStatus', 'filterMekanik', 'perPage'], true)) {
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
        $perPage = in_array((int) $this->perPage, self::PER_PAGE_OPTIONS, true)
            ? (int) $this->perPage
            : 10;

        $query = $this->baseQuery()->orderByDesc('tanggal')->orderByDesc('jam_masuk');
        $antreans = $query->paginate($perPage);

        if ($antreans->currentPage() > $antreans->lastPage()) {
            $this->setPage($antreans->lastPage());
            $antreans = $query->paginate($perPage);
        }

        // Ringkasan keseluruhan (murni rentang tanggal, tidak kena filter status/mekanik)
        $ringkasan = Antrean::whereBetween('tanggal', [$this->tanggal_awal, $this->tanggal_akhir])
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalMenunggu = $ringkasan['menunggu'] ?? 0;
        $totalDikerjakan = $ringkasan['dikerjakan'] ?? 0;
        $totalSelesai = $ringkasan['selesai'] ?? 0;
        $totalMasuk = $totalMenunggu + $totalDikerjakan + $totalSelesai;

        // Rekap per mekanik: 1 query untuk semua pekerjaan selesai, dikelompokkan di PHP
        // (sebelumnya 1 query per mekanik)
        $selesaiPerMekanik = Antrean::whereBetween('tanggal', [$this->tanggal_awal, $this->tanggal_akhir])
            ->where('status', 'selesai')
            ->whereNotNull('mekanik_id')
            ->get(['mekanik_id', 'jam_masuk', 'jam_selesai'])
            ->groupBy('mekanik_id');

        $rekapMekanik = Mekanik::orderBy('nama')->get()
            ->map(function ($mekanik) use ($selesaiPerMekanik) {
                $baris = $selesaiPerMekanik->get($mekanik->id, collect());
                $denganDurasi = $baris->filter(fn ($a) => $a->jam_selesai !== null);

                $mekanik->total_selesai = $baris->count();
                $mekanik->rata_rata_menit = $denganDurasi->isNotEmpty()
                    ? (int) round($denganDurasi->avg(fn ($a) => $a->jam_masuk->diffInMinutes($a->jam_selesai)))
                    : null;

                return $mekanik;
            })
            ->sortByDesc('total_selesai')
            ->values();

        return view('livewire.laporan.index', [
            'antreans' => $antreans,
            'perPageOptions' => self::PER_PAGE_OPTIONS,
            'totalMasuk' => $totalMasuk,
            'totalSelesai' => $totalSelesai,
            'totalDikerjakan' => $totalDikerjakan,
            'totalMenunggu' => $totalMenunggu,
            'rekapMekanik' => $rekapMekanik,
            'daftarMekanik' => Mekanik::orderBy('nama')->get(),
        ]);
    }
}
