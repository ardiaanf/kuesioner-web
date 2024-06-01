<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudyProgram;

class StudyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $study_programs = [
            'Teknik Informatika',
            'Sistem Informasi',
            'Teknik Elektro',
        ];

        foreach ($study_programs as $study_program) {
            StudyProgram::create([
                'name' => $study_program,
            ]);
        }
    }
}
