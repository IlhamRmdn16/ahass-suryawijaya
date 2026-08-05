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

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function antreans()
    {
        return $this->hasMany(Antrean::class);
    }

    public function antreanAktif()
    {
        return $this->hasOne(Antrean::class)
            ->where('status', 'dikerjakan')
            ->latestOfMany('jam_masuk');
    }

    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }
}
