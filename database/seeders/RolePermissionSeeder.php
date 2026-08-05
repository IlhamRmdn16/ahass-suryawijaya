<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache permission (wajib, biar Spatie ga pakai cache lama)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Antrean
            'create antrean',
            'edit antrean',
            'delete antrean',
            'assign antrean',       // dorong antrean ke mekanik
            'print antrean',
            'view antrean',

            // Mekanik (master data)
            'manage mekanik',

            // Jenis Pekerjaan (master data)
            'manage jenis pekerjaan',

            // Mekanik operasional
            'view own antrean',     // mekanik lihat tugas sendiri
            'update status selesai',// mekanik klik "Selesai"

            // Admin bisa menyelesaikan antrean atas nama mekanik (jaga-jaga lupa)
            'selesaikan antrean',

            // User & role management
            'manage users',

            // Laporan
            'view laporan',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ── Role: super admin → semua permission ──
        $superAdmin = Role::firstOrCreate(['name' => 'super admin']);
        $superAdmin->syncPermissions(Permission::all());

        // ── Role: entry → input & print antrean ──
        $entry = Role::firstOrCreate(['name' => 'entry']);
        $entry->syncPermissions([
            'create antrean',
            'edit antrean',
            'print antrean',
            'view antrean',
        ]);

        // ── Role: mekanik → hanya lihat & selesaikan tugas sendiri ──
        $mekanik = Role::firstOrCreate(['name' => 'mekanik']);
        $mekanik->syncPermissions([
            'view own antrean',
            'update status selesai',
        ]);

        // ── Role: viewer → read only ──
        $viewer = Role::firstOrCreate(['name' => 'viewer']);
        $viewer->syncPermissions([
            'view antrean',
            'view laporan',
        ]);

        $this->command->info('Role & permission berhasil dibuat: super admin, entry, mekanik, viewer');
    }
}
