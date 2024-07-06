<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LecturerStudyProgram;

class LecturerStudyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LecturerStudyProgram::create([
            'lecturer_id' => 1,
            'study_program_id' => 1,
        ]);

        LecturerStudyProgram::create([
            'lecturer_id' => 1,
            'study_program_id' => 2,
        ]);

        LecturerStudyProgram::create([
            'lecturer_id' => 2,
            'study_program_id' => 3,
        ]);
    }
}
