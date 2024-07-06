<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudentQuestion;

class StudentQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentQuestion::create([
            'question' => 'Example Question 1 (Student Element 1)',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Strongly Disagree', 'Disagree', 'Agree', 'Strongly Agree']),
            'student_element_id' => 1,
        ]);

        StudentQuestion::create([
            'question' => 'Example Question 2 (Student Element 1)',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Strongly Disagree', 'Disagree', 'Agree', 'Strongly Agree']),
            'student_element_id' => 1,
        ]);

        StudentQuestion::create([
            'question' => 'Example Question 3 (Student Element 2)',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Strongly Disagree', 'Disagree', 'Agree', 'Strongly Agree']),
            'student_element_id' => 2,
        ]);

        StudentQuestion::create([
            'question' => 'Example Question 4 (Student Element 2)',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Strongly Disagree', 'Disagree', 'Agree', 'Strongly Agree']),
            'student_element_id' => 2,
        ]);
    }
}
