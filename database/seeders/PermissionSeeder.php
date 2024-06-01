<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = [
            'users',
            'roles',
        ];

        foreach ($models as $model) {
            Permission::create([
                'name' => "create_{$model}",
                'guard_name' => 'web',
            ]);

            Permission::create([
                'name' => "read_{$model}",
                'guard_name' => 'web',
            ]);

            Permission::create([
                'name' => "show_{$model}",
                'guard_name' => 'web',
            ]);

            Permission::create([
                'name' => "update_{$model}",
                'guard_name' => 'web',
            ]);

            Permission::create([
                'name' => "delete_{$model}",
                'guard_name' => 'web',
            ]);
        }

        Permission::create([
            'name' => 'read_permissions',
            'guard_name' => 'web',
        ]);
    }
}
