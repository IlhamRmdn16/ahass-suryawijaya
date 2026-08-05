<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPekerjaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pekerjaan',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    public function antreans()
    {
        return $this->hasMany(Antrean::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }
}
