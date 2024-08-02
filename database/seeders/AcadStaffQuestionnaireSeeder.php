<?php

namespace Database\Seeders;

use App\Models\AcadStaffQuestionnaire as ModelsAcadStaffQuestionnaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcadStaffQuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsAcadStaffQuestionnaire::create([
            'name' => "Kuesioner civitas akademika tenaga kependidikan",
            'description' => null,
            'admin_id' => 1,
        ]);
    }
}
