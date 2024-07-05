<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudentClass;

class StudentClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentClass::create([
            'name' => 'DKV 1',
            'study_program_id' => 1,
        ]);

        StudentClass::create([
            'name' => 'RPL 1',
            'study_program_id' => 2,
        ]);

        StudentClass::create([
            'name' => 'BCT 1',
            'study_program_id' => 3,
        ]);
    }
}
