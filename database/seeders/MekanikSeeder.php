<?php

namespace Database\Seeders;

use App\Models\Mekanik;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MekanikSeeder extends Seeder
{
    public function run(): void
    {
        $namaMekanik = [
            'Budi Santoso',
            'Agus Prasetyo',
            'Dedi Kurniawan',
            'Eko Wahyudi',
            'Fajar Ramadhan',
        ];

        foreach ($namaMekanik as $nama) {
            $mekanik = Mekanik::create([
                'nama' => $nama,
                'status_aktif' => true,
            ]);

            $username = strtolower(str_replace(' ', '', $nama));

            $user = User::create([
                'name' => $nama,
                'email' => $username . '@ahass.local',
                'password' => Hash::make('password123'), // WAJIB diganti setelah setup awal
                'mekanik_id' => $mekanik->id,
                'email_verified_at' => now(),
            ]);

            $user->assignRole('mekanik');
        }

        $this->command->info('5 mekanik + akun login berhasil dibuat. Password default: password123');
    }
}
