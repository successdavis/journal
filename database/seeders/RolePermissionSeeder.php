<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'create journal',
            'edit journal',
            'delete journal',
            'submit journal',
            'review journal',
            'publish journal',
            'view journal',
            'manage users',
            'assign roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        Role::firstOrCreate(['name' => 'Super Admin'])->givePermissionTo(Permission::all());

        Role::firstOrCreate(['name' => 'Editor'])->givePermissionTo([
            'create journal',
            'edit journal',
            'delete journal',
            'publish journal',
            'view journal',
            'review journal',
        ]);

        Role::firstOrCreate(['name' => 'Reviewer'])->givePermissionTo([
            'review journal',
            'view journal',
        ]);

        Role::firstOrCreate(['name' => 'Author'])->givePermissionTo([
            'submit journal',
            'view journal',
        ]);

        Role::firstOrCreate(['name' => 'Reader'])->givePermissionTo([
            'view journal',
        ]);
    }
}
