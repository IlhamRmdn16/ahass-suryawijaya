<?php

namespace Database\Seeders;

use App\Models\JenisPekerjaan;
use Illuminate\Database\Seeder;

class JenisPekerjaanSeeder extends Seeder
{
    public function run(): void
    {
        $daftar = [
            'Servis Rutin',
            'Ganti Oli',
            'Tune Up',
            'Ganti Ban',
            'Servis Karburator/Injeksi',
            'Servis Rem',
            'Ganti Aki',
            'Servis CVT (Matic)',
            'Perbaikan Kelistrikan',
            'Klaim Sparepart',
        ];

        foreach ($daftar as $nama) {
            JenisPekerjaan::firstOrCreate(['nama_pekerjaan' => $nama]);
        }

        $this->command->info('Data jenis pekerjaan berhasil dibuat. Silakan sesuaikan lagi via halaman admin.');
    }
}
