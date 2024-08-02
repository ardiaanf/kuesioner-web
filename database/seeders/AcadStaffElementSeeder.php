<?php

namespace Database\Seeders;

use App\Models\AcadStaffElement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcadStaffElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AcadStaffElement::create([
            'name' => 'Visi, Misi, Tujuan, dan Strategi',
            'description' => 'Deskripsi elemen',
            'acad_staff_questionnaire_id' => 1, // Menggunakan ID 1 langsung
        ]);

        AcadStaffElement::create([
            'name' => 'Tata Pamong dan Kerjasama',
            'description' => 'Deskripsi elemen',
            'acad_staff_questionnaire_id' => 1, // Menggunakan ID 1 langsung
        ]);
    }
}
