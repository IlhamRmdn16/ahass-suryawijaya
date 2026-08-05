<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mekanik extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'foto',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    /**
     * Akun login milik mekanik ini (role: mekanik).
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Semua antrean/riwayat pekerjaan yang pernah ditangani mekanik ini.
     * (Model Antrean akan kita buat di modul selanjutnya)
     */
    public function antreans()
    {
        return $this->hasMany(Antrean::class);
    }

    /**
     * Pekerjaan yang SEDANG dikerjakan mekanik ini saat ini.
     * Dipakai di Monitor Board supaya setiap kolom mekanik
     * langsung tahu "sedang ngerjain apa".
     */
    public function antreanAktif()
    {
        return $this->hasOne(Antrean::class)
            ->where('status', 'dikerjakan')
            ->latestOfMany('jam_masuk');
    }

    /**
     * Scope: hanya mekanik yang aktif (untuk dropdown assign & monitor board).
     */
    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }
}
