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
        StudyProgram::create([
            'name' => 'Desain Komunikasi Visual',
            'major_id' => 1
        ]);

        StudyProgram::create([
            'name' => 'Rekayasa Perangkat Lunak',
            'major_id' => 2
        ]);

        StudyProgram::create([
            'name' => 'Broadcasting',
            'major_id' => 3
        ]);
    }
}
