<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            MekanikSeeder::class,
            JenisPekerjaanSeeder::class,
        ]);

        // Akun super admin pertama, langsung dibuat di sini
        // supaya kamu tidak perlu buka tinker manual.
        $superAdmin = User::create([
            'name' => 'Admin Bengkel',
            'email' => 'admin@ahass.local',
            'password' => Hash::make('admin123'), // WAJIB diganti setelah login pertama
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('super admin');

        $this->command->info('Akun super admin dibuat: admin@ahass.local / admin123');
    }
}
