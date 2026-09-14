<?php

namespace App\Http\Controllers;

use App\Models\Pkb;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PkbPdfController extends Controller
{
    public function download(Pkb $pkb)
    {
        abort_unless(auth()->user()->can('buat pkb'), 403);
        abort_unless($pkb->status === 'selesai', 404, 'PKB belum lengkap, No. PKB/WO belum diisi admin.');

        Carbon::setLocale('id');

        $pkb->load('antrean');

        $pdf = Pdf::loadView('pkb.pdf', ['pkb' => $pkb])
            ->setPaper('a4', 'portrait');

        return $pdf->stream('PKB-' . $pkb->antrean->no_polisi . '.pdf');
        // Kalau mau paksa download (bukan buka di tab baru), ganti baris
        // di atas jadi: return $pdf->download('PKB-' . $pkb->antrean->no_polisi . '.pdf');
    }
}
