<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudentElement;

class StudentElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentElement::create([
            'name' => 'Student Element 1',
            'description' => 'This is the first student element.',
            'student_questionnaire_id' => 1,
        ]);

        StudentElement::create([
            'name' => 'Student Element 2',
            'description' => 'This is the second student element.',
            'student_questionnaire_id' => 1,
        ]);
    }
}
