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
        $faker = \Faker\Factory::create('id_ID');

        Student::create([
            'name' => $faker->name,
            'reg_number' => $faker->unique()->regexify('S[0-9]{3}'),
            'email' =>  $faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'gender' => rand(0, 1) ? 'male' : 'female',
            'semester' => rand(1, 8),
            'major_id' => 1,
            'study_program_id' => 1,
            'student_class_id' => 1,
        ]);

        Student::create([
            'name' => $faker->name,
            'reg_number' => $faker->unique()->regexify('S[0-9]{3}'),
            'email' =>  $faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'gender' => rand(0, 1) ? 'male' : 'female',
            'semester' => rand(1, 8),
            'major_id' => 2,
            'study_program_id' => 2,
            'student_class_id' => 2,
        ]);

        Student::create([
            'name' => $faker->name,
            'reg_number' => $faker->unique()->regexify('S[0-9]{3}'),
            'email' =>  $faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'gender' => rand(0, 1) ? 'male' : 'female',
            'semester' => rand(1, 8),
            'major_id' => 3,
            'study_program_id' => 3,
            'student_class_id' => 3,
        ]);
    }
}
