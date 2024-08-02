<?php

namespace Database\Seeders;

use App\Models\LecturerQuestionnaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LecturerQuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LecturerQuestionnaire::create([
            'name' => "Kuesioner civitas akademika dosen",
            'description' => null,
            'admin_id' => 1,
        ]);
    }
}
