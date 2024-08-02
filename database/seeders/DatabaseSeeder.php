<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(MajorSeeder::class);
        $this->call(StudyProgramSeeder::class);
        $this->call(StudentClassSeeder::class);
        $this->call(LecturerEmploymentStatusSeeder::class);
        $this->call(AcadStaffDepartmentSeeder::class);
        $this->call(AcadStaffWorkUnitSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(LecturerSeeder::class);
        $this->call(AcadStaffSeeder::class);
        $this->call(StudentQuestionnaireSeeder::class);
        $this->call(StudentElementSeeder::class);
        $this->call(StudentQuestionSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(StudentCourseSeeder::class);
        $this->call(LecturerStudyProgramSeeder::class);
        $this->call(LecturerCourseSeeder::class);
        $this->call(LecturerQuestionnaireSeeder::class);
        $this->call(LecturerElementSeeder::class);
        $this->call(LecturerQuestionSeeder::class);
        $this->call(StudentAnswerTlpSeeder::class);
        $this->call(AcadStaffQuestionnaireSeeder::class);
        $this->call(AcadStaffElementSeeder::class);
        $this->call(AcadStaffQuestionSeeder::class);
    }
}
