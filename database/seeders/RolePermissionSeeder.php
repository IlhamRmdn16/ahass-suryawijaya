<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Antrean
            'create antrean',
            'edit antrean',
            'delete antrean',
            'assign antrean',
            'print antrean',
            'view antrean',

            // Mekanik (master data)
            'manage mekanik',

            // Jenis Pekerjaan (master data)
            'manage jenis pekerjaan',

            // Mekanik operasional
            'view own antrean',
            'update status selesai',

            // Admin bisa menyelesaikan antrean atas nama mekanik (jaga-jaga lupa)
            'selesaikan antrean',

            // PKB (Perintah Kerja Bengkel) -- HANYA entry & super admin
            // yang boleh akses fitur ini sama sekali (bukan viewer/mekanik)
            'buat pkb',      // entry & admin bisa buka form, isi centang + ttd konsumen
            'isi no pkb',    // KHUSUS admin, isi No. PKB/WO setelah ditandatangani

            // User & role management
            'manage users',

            // Laporan
            'view laporan',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ── Role: super admin -> semua permission ──
        $superAdmin = Role::firstOrCreate(['name' => 'super admin']);
        $superAdmin->syncPermissions(Permission::all());

        // ── Role: entry -> input & print antrean + PKB (TANPA isi no pkb) ──
        $entry = Role::firstOrCreate(['name' => 'entry']);
        $entry->syncPermissions([
            'create antrean',
            'edit antrean',
            'print antrean',
            'view antrean',
            'buat pkb',
        ]);

        // ── Role: mekanik -> hanya lihat & selesaikan tugas sendiri ──
        $mekanik = Role::firstOrCreate(['name' => 'mekanik']);
        $mekanik->syncPermissions([
            'view own antrean',
            'update status selesai',
        ]);

        // ── Role: viewer -> read only ──
        $viewer = Role::firstOrCreate(['name' => 'viewer']);
        $viewer->syncPermissions([
            'view antrean',
            'view laporan',
        ]);

        $this->command->info('Role & permission berhasil dibuat/diperbarui: super admin, entry, mekanik, viewer');
    }
}
