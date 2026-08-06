<?php

namespace App\Http\Controllers;

use App\Models\Antrean;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanPrintController extends Controller
{
    public function show(Request $request, string $tanggal)
    {
        abort_unless(auth()->user()->can('view laporan'), 403);

        $tanggalCarbon = Carbon::parse($tanggal);
        Carbon::setLocale('id'); // pastikan nama hari & bulan Indonesia walau APP_LOCALE belum di-set

        $antreans = Antrean::with(['mekanik', 'jenisPekerjaan'])
            ->whereDate('tanggal', $tanggalCarbon->format('Y-m-d'))
            ->orderBy('jam_masuk')
            ->get();

        return view('laporan.print', [
            'tanggal' => $tanggalCarbon,
            'antreans' => $antreans,
        ]);
    }
}
