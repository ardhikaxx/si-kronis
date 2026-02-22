<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'dashboard.pasien',
            'dashboard.admin',
            'konsultasi.booking',
            'konsultasi.manage',
            'dokter.manage',
            'resep.create',
            'resep.view',
            'lab.upload',
            'lab.review',
            'user.manage',
            'laporan.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $pasien = Role::firstOrCreate(['name' => 'pasien']);
        $pasien->syncPermissions([
            'dashboard.pasien',
            'konsultasi.booking',
            'resep.view',
            'lab.upload',
        ]);

        $perawat = Role::firstOrCreate(['name' => 'perawat']);
        $perawat->syncPermissions([
            'dashboard.admin',
            'konsultasi.manage',
            'resep.view',
            'lab.upload',
            'lab.review',
        ]);

        $dokter = Role::firstOrCreate(['name' => 'dokter']);
        $dokter->syncPermissions([
            'dashboard.admin',
            'konsultasi.manage',
            'resep.create',
            'resep.view',
            'lab.review',
            'laporan.view',
        ]);

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());
    }
}
