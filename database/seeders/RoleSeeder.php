<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $admin_roles = [
            'users',
            'roles',
        ];

        foreach ($admin_roles as $role) {
            $admin->givePermissionTo("create_{$role}");
            $admin->givePermissionTo("read_{$role}");
            $admin->givePermissionTo("show_{$role}");
            $admin->givePermissionTo("update_{$role}");
            $admin->givePermissionTo("delete_{$role}");
        }

        $admin->givePermissionTo('read_permissions');

        $lecturer = Role::create([
            'name' => 'dosen',
            'guard_name' => 'web'
        ]);

        $student = Role::create([
            'name' => 'mahasiswa',
            'guard_name' => 'web'
        ]);

        $educationPersonnel = Role::create([
            'name' => 'tendik',
            'guard_name' => 'web'
        ]);
    }
}
