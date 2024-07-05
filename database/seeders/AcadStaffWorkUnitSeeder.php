<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcadStaffWorkUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AcadStaffWorkUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AcadStaffWorkUnit::create([
            'name' => 'Human Resources',
            'acad_staff_department_id' => 1,
        ]);

        AcadStaffWorkUnit::create([
            'name' => 'IT Support',
            'acad_staff_department_id' => 2,
        ]);
    }
}
