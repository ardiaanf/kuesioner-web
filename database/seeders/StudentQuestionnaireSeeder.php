<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudentQuestionnaire;

class StudentQuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentQuestionnaire::create([
            'name' => 'Student Questionnaire 1',
            'description' => 'This is the first student questionnaire.',
            'type' => 'TLP',
            'admin_id' => 1,
        ]);
    }
}
