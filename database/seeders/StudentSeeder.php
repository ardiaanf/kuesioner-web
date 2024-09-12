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
            'name' => 'Student',
            'reg_number' => '365155401020',
            'email' =>  'student@mail.com',
            'password' => bcrypt('password'),
            'gender' => rand(1, 0) ? 'male' : 'female',
            'semester' => rand(1, 8),
            'major_id' => 2,
            'study_program_id' => 2,
            'student_class_id' => 6,
        ]);

        Student::create([
            'name' => 'NIA RIZKIKA',
            'reg_number' => '362393301081',
            'email' =>  'niarizkika12@gmail.com',
            'password' => bcrypt('password'),
            'gender' => rand(0, 1) ? 'male' : 'female',
            'semester' => rand(1, 8),
            'major_id' => 1,
            'study_program_id' => 1,
            'student_class_id' => 2,
        ]);

        Student::create([
            'name' => 'WILDA FATIMATUL ZAHRA',
            'reg_number' => '362393301011',
            'email' =>  'wildafatimatuzs@gmail.com',
            'password' => bcrypt('password'),
            'gender' => rand(0, 1) ? 'male' : 'female',
            'semester' => rand(1, 8),
            'major_id' => 1,
            'study_program_id' => 1,
            'student_class_id' => 1,
        ]);

        Student::create([
            'name' => 'MULYA NUR AINI',
            'reg_number' => '362393301154',
            'email' =>  'mulyanuraini14@gmail.com',
            'password' => bcrypt('password'),
            'gender' => rand(0, 1) ? 'male' : 'female',
            'semester' => rand(1, 8),
            'major_id' => 1,
            'study_program_id' => 1,
            'student_class_id' => 3,
        ]);

        Student::create([
            'name' => 'YOLANDA DIVA LOKA',
            'reg_number' => '362393301066',
            'email' =>  'yolandadivaloka@icloud.com',
            'password' => bcrypt('password'),
            'gender' => rand(0, 1) ? 'male' : 'female',
            'semester' => rand(1, 8),
            'major_id' => 1,
            'study_program_id' => 1,
            'student_class_id' => 1,
        ]);

        Student::create([
            'name' => 'YUNITA MEDYAWATI',
            'reg_number' => '362393301075',
            'email' =>  'yunitameywa25@gmail.com',
            'password' => bcrypt('password'),
            'gender' => rand(0, 1) ? 'male' : 'female',
            'semester' => rand(1, 8),
            'major_id' => 1,
            'study_program_id' => 1,
            'student_class_id' => 1,
        ]);

        Student::create([
            'name' => 'IVO DWI NANDA ',
            'reg_number' => '362393301002',
            'email' =>  'ivodwinanda@gmail.com',
            'password' => bcrypt('password'),
            'gender' => rand(0, 1) ? 'male' : 'female',
            'semester' => rand(1, 8),
            'major_id' => 1,
            'study_program_id' => 1,
            'student_class_id' => 1,
        ]);

        Student::create([
            'name' => 'VINA YULIANA ',
            'reg_number' => '362393301004',
            'email' =>  'vinayuliana874@gmail.com',
            'password' => bcrypt('password'),
            'gender' => rand(0, 1) ? 'male' : 'female',
            'semester' => rand(1, 8),
            'major_id' => 1,
            'study_program_id' => 1,
            'student_class_id' => 4,
        ]);

        Student::create([
            'name' => 'CITRA PERMATA SARI ',
            'reg_number' => '362393301058',
            'email' =>  'permatasaric967@gmail.com',
            'password' => bcrypt('password'),
            'gender' => rand(0, 1) ? 'male' : 'female',
            'semester' => rand(1, 8),
            'major_id' => 1,
            'study_program_id' => 1,
            'student_class_id' => 5,
        ]);

        Student::create([
            'name' => 'MUHAMMAD SABDA AQILA ',
            'reg_number' => '362393301088',
            'email' =>  'kikikiko689@gmail.com',
            'password' => bcrypt('password'),
            'gender' => rand(1, 0) ? 'male' : 'female',
            'semester' => rand(1, 8),
            'major_id' => 1,
            'study_program_id' => 1,
            'student_class_id' => 2,
        ]);

        Student::create([
            'name' => 'ANGGUN KHOERUNISA',
            'reg_number' => '362393301030',
            'email' =>  'anggunkhnisa8@gmail.com',
            'password' => bcrypt('password'),
            'gender' => rand(0, 1) ? 'male' : 'female',
            'semester' => rand(1, 8),
            'major_id' => 1,
            'study_program_id' => 1,
            'student_class_id' => 3,
        ]);

        Student::create([
            'name' => 'Fio Dwi Agustine',
            'reg_number' => '362393301671',
            'email' =>  'fiodwi24@gmail.com',
            'password' => bcrypt('password'),
            'gender' => rand(0, 1) ? 'male' : 'female',
            'semester' => rand(1, 8),
            'major_id' => 1,
            'study_program_id' => 1,
            'student_class_id' => 1,
        ]);

        Student::create([
            'name' => 'FIRMAN BAYU NUGROHO ',
            'reg_number' => '362393301009',
            'email' =>  'firmanbayunugroho478@gmail.com',
            'password' => bcrypt('password'),
            'gender' => rand(0, 1) ? 'male' : 'female',
            'semester' => rand(1, 8),
            'major_id' => 1,
            'study_program_id' => 1,
            'student_class_id' => 1,
        ]);
    }
}
