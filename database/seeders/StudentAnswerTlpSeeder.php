<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudentAnswerDetailTlp;
use App\Models\StudentAnswerTlp;

class StudentAnswerTlpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $studentAnswerTlp1 = StudentAnswerDetailTlp::create([
            'major_id' => 1,
            'study_program_id' => 1,
            'student_class_id' => 1,
            'course_id' => 3,
            'lecturer_id' => 1,
            'student_id' => 1
        ]);

        for ($i = 1; $i <= 5; $i++) {
            $studentAnswerTlp1->studentAnswerTlp()->create([
                'answer' => rand(1, 4),
                'student_answer_detail_tlp_id' => $studentAnswerTlp1->id,
                'student_questionnaire_id' => 1,
                'student_element_id' => 1,
                'student_question_id' => $i,
            ]);
        }

        for ($i = 6; $i <= 10; $i++) {
            $studentAnswerTlp1->studentAnswerTlp()->create([
                'answer' => rand(1, 4),
                'student_answer_detail_tlp_id' => $studentAnswerTlp1->id,
                'student_questionnaire_id' => 1,
                'student_element_id' => 2,
                'student_question_id' => $i,
            ]);
        }

        $studentAnswerTlp2 = StudentAnswerDetailTlp::create([
            'major_id' => 1,
            'study_program_id' => 1,
            'student_class_id' => 1,
            'course_id' => 3,
            'lecturer_id' => 2,
            'student_id' => 2
        ]);

        for ($i = 1; $i <= 5; $i++) {
            $studentAnswerTlp2->studentAnswerTlp()->create([
                'answer' => rand(1, 4),
                'student_answer_detail_tlp_id' => $studentAnswerTlp2->id,
                'student_questionnaire_id' => 1,
                'student_element_id' => 1,
                'student_question_id' => $i,
            ]);
        }

        for ($i = 6; $i <= 10; $i++) {
            $studentAnswerTlp2->studentAnswerTlp()->create([
                'answer' => rand(1, 4),
                'student_answer_detail_tlp_id' => $studentAnswerTlp2->id,
                'student_questionnaire_id' => 1,
                'student_element_id' => 2,
                'student_question_id' => $i,
            ]);
        }
    }
}
