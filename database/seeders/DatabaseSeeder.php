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
    }
}
