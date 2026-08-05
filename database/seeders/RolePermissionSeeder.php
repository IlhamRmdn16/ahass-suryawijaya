<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'create antrean',
            'edit antrean',
            'delete antrean',
            'assign antrean',
            'print antrean',
            'view antrean',
            'manage mekanik',
            'manage jenis pekerjaan',
            'view own antrean', 
            'update status selesai',
            'manage users',
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
