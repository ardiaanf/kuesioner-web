<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LecturerCourse;

class LecturerCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        LecturerCourse::create([
            'lecturer_id' => 1,
            'course_id' => 1,
        ]);

        LecturerCourse::create([
            'lecturer_id' => 1,
            'course_id' => 2,
        ]);

        LecturerCourse::create([
            'lecturer_id' => 1,
            'course_id' => 3,
        ]);

        LecturerCourse::create([
            'lecturer_id' => 2,
            'course_id' => 3,
        ]);

        LecturerCourse::create([
            'lecturer_id' => 2,
            'course_id' => 4,
        ]);
    }
}
