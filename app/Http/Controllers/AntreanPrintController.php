<?php

namespace App\Http\Controllers;

use App\Models\Antrean;

class AntreanPrintController extends Controller
{
    public function show(Antrean $antrean)
    {
        abort_unless(auth()->user()->can('print antrean'), 403);

        $antrean->load(['mekanik', 'jenisPekerjaan']);

        return view('antrean.print', compact('antrean'));
    }
}
