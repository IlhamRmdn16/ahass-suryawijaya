<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pkb extends Model
{
    use HasFactory;

    protected $fillable = [
        'antrean_id',
        'nama_konsumen',
        'setuju_1',
        'setuju_2',
        'tanda_tangan',
        'ditandatangani_pada',
        'no_pkb',
        'diisi_oleh',
        'diisi_pada',
        'status',
        'created_by',
    ];

    protected $casts = [
        'setuju_1' => 'boolean',
        'setuju_2' => 'boolean',
        'ditandatangani_pada' => 'datetime',
        'diisi_pada' => 'datetime',
    ];

    public function antrean()
    {
        return $this->belongsTo(Antrean::class);
    }

    public function petugasIsi()
    {
        return $this->belongsTo(User::class, 'diisi_oleh');
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getTandaTanganUrlAttribute(): ?string
    {
        return $this->tanda_tangan ? asset('storage/' . $this->tanda_tangan) : null;
    }
}
