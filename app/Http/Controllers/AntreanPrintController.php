<?php

namespace App\Http\Controllers;

use App\Models\Antrean;
use Carbon\Carbon;

class AntreanPrintController extends Controller
{
    public function show(Antrean $antrean)
    {
        abort_unless(auth()->user()->can('print antrean'), 403);

        Carbon::setLocale('id');
        $antrean->load(['mekanik', 'jenisPekerjaan']);

        return view('antrean.print', compact('antrean'));
    }
}
