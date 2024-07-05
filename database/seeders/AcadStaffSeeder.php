<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcadStaff;

class AcadStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AcadStaff::create([
            'name' => 'Academic Staff',
            'reg_number' => 'A001',
            'email' => 'acadstaff@mail.com',
            'password' => bcrypt('password'),
            'acad_staff_work_unit_id' => 1,
        ]);
    }
}
