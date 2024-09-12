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
            'name' => 'MBP 1A',
            'study_program_id' => 1,
        ]);

        StudentClass::create([
            'name' => 'MBP 1B',
            'study_program_id' => 1,
        ]);

        StudentClass::create([
            'name' => 'MBP 1C',
            'study_program_id' => 1,
        ]);

        StudentClass::create([
            'name' => 'MBP 1D',
            'study_program_id' => 1,
        ]);

        StudentClass::create([
            'name' => 'MBP 1E',
            'study_program_id' => 1,
        ]);

        StudentClass::create([
            'name' => 'TRPL 1A',
            'study_program_id' => 2,
        ]);

    }
}
