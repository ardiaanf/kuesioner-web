<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = [
            [
                'name' => 'Computer Science',
                'code' => 'CSC101',
                'semester' => 1,
                'study_program_id' => 2,
            ],
            [
                'name' => 'Mathematics',
                'code' => 'MAT101',
                'semester' => 1,
                'study_program_id' => 2,
            ],
            [
                'name' => 'Design Graphic',
                'code' => 'DG101',
                'semester' => 1,
                'study_program_id' => 1,
            ],
            [
                'name' => 'Photography',
                'code' => 'PG101',
                'semester' => 1,
                'study_program_id' => 1,
            ],
            [
                'name' => 'Television Production',
                'code' => 'TP101',
                'semester' => 1,
                'study_program_id' => 3,
            ]
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
