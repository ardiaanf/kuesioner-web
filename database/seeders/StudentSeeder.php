<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::create([
            'name' => 'Student',
            'reg_number' => 'S001',
            'email' => 'student@mail.com',
            'password' => bcrypt('password'),
            'semester' => '1',
            'study_program_id' => 1,
            'student_class_id' => 1,
        ]);
    }
}
