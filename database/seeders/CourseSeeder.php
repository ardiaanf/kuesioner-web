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
                'name' => 'Pengantar Manajemen',
                'code' => 'MBP1101',
                'semester' => 1,
                'study_program_id' => 1,
            ],
            [
                'name' => 'Pengantar Usaha Perjalanan Wisata',
                'code' => 'MBP31003',
                'semester' => 1,
                'study_program_id' => 1,
            ],
            [
                'name' => 'Pariwisata Hospitality',
                'code' => 'MBP31001 ',
                'semester' => 1,
                'study_program_id' => 1,
            ],
            [
                'name' => 'Aplikasi Komputer',
                'code' => 'MBP31004 ',
                'semester' => 1,
                'study_program_id' => 1,
            ],
            [
                'name' => 'Pemograman Dasar',
                'code' => 'PD101',
                'semester' => 1,
                'study_program_id' => 2,
            ]
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
