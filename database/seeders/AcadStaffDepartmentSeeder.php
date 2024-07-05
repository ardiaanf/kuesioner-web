<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcadStaffDepartment;

class AcadStaffDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AcadStaffDepartment::create([
            'name' => 'Administration',
        ]);

        AcadStaffDepartment::create([
            'name' => 'Information Technology',
        ]);
    }
}
