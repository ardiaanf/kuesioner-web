<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudentQuestionnaire;

class StudentQuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentQuestionnaire::create([
            'name' => "Kuesioner PBM Ganjil Kelas 1",
            'description' => null,
            'type' => 'TLP',
            'admin_id' => 1,
        ]);

        StudentQuestionnaire::create([
            'name' => "Kuesioner CA Mahasiswa",
            'description' => null,
            'type' => 'AC',
            'admin_id' => 1,
        ]);

        StudentQuestionnaire::create([
            'name' => "Kuesioner CA Dosen",
            'description' => null,
            'type' => 'AC',
            'admin_id' => 1,
        ]);

        StudentQuestionnaire::create([
            'name' => "Kuesioner CA Tendik",
            'description' => null,
            'type' => 'AC',
            'admin_id' => 1,
        ]);
    }
}
