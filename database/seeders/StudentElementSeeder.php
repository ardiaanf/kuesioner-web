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
            'name' => 'Teori',
            'description' => null,
            'student_questionnaire_id' => 1,
        ]);

        StudentElement::create([
            'name' => 'Praktikum',
            'description' => null,
            'student_questionnaire_id' => 1,
        ]);

        StudentElement::create([
            'name' => 'Visi, Misi, Tujuan, dan Strategi',
            'description' => null,
            'student_questionnaire_id' => 2,
        ]);

        StudentElement::create([
            'name' => 'Tata Pamong, Tata Kelola, dan Kerjasama',
            'description' => null,
            'student_questionnaire_id' => 2,
        ]);
    }
}
