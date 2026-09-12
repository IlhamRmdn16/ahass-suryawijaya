<?php

namespace Database\Seeders;

use App\Models\JenisPekerjaan;
use Illuminate\Database\Seeder;

class JenisPekerjaanSeeder extends Seeder
{
    public function run(): void
    {
        $daftar = [
            'Service Bayar (QS)',
            'Ganti Oli (OR)',
            'Pasang Sparepart (IS)',
            'Kupon Perawatan Berkala (KPB)',
        ];

        foreach ($daftar as $nama) {
            JenisPekerjaan::firstOrCreate(['nama_pekerjaan' => $nama]);
        }

        $this->command->info('Data jenis pekerjaan berhasil dibuat. Silakan sesuaikan lagi via halaman admin.');
    }
}
