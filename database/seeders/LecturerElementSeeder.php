<?php

namespace Database\Seeders;

use App\Models\LecturerElement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LecturerElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LecturerElement::create([
            'name' => 'Visi, Misi, Tujuan, dan Strategi',
            'description' => null,
            'lecturer_questionnaire_id' => 1,
        ]);

        LecturerElement::create([
            'name' => 'Tata Pamong, Tata Kelola, dan Kerjasama',
            'description' => null,
            'lecturer_questionnaire_id' => 1,
        ]);
    }
}
