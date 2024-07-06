<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudentCourse;

class StudentCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentCourse::create([
            'student_id' => 1,
            'course_id' => 1,
        ]);
        StudentCourse::create([
            'student_id' => 1,
            'course_id' => 2,
        ]);
    }
}
