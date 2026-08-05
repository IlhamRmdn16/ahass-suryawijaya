<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrean extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'no_polisi',
        'tipe_motor',
        'jam_masuk',
        'jam_selesai',
        'mekanik_id',
        'jenis_pekerjaan_id',
        'no_hp',
        'daya_auto',
        'status',
        'created_by',
        'assigned_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
        'jam_selesai' => 'datetime',
        'daya_auto' => 'boolean',
    ];

    public function mekanik()
    {
        return $this->belongsTo(Mekanik::class);
    }

    public function jenisPekerjaan()
    {
        return $this->belongsTo(JenisPekerjaan::class);
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pemberiTugas()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function scopeTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal', $tanggal);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Label status yang ramah ditampilkan di badge.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu',
            'dikerjakan' => 'Dikerjakan',
            'selesai' => 'Selesai',
            default => $this->status,
        };
    }

    /**
     * Durasi pengerjaan (untuk laporan nanti).
     */
    public function getDurasiMenitAttribute(): ?int
    {
        if (! $this->jam_masuk || ! $this->jam_selesai) {
            return null;
        }

        return $this->jam_masuk->diffInMinutes($this->jam_selesai);
    }
}
