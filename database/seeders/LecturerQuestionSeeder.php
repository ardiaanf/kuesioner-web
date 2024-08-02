<?php

namespace Database\Seeders;

use App\Models\LecturerQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LecturerQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LecturerQuestion::create([
            'question' => 'Visi, Misi, Tujuan Politeknik Negeri Banyuwangi telah disosialisasikan secara jelas melalui berbagai kegiatan dan/atau media',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'lecturer_element_id' => 1,
        ]);

        LecturerQuestion::create([
            'question' => 'Visi, Misi, Tujuan Politeknik Negeri Banyuwangi telah disosialisasikan secara berkala melalui berbagai kegiatan dan/atau media',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'lecturer_element_id' => 1,
        ]);

        LecturerQuestion::create([
            'question' => 'Dosen telah mengetahui struktur organisasi Politeknik Negeri Banyuwangi secara jelas',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'lecturer_element_id' => 2,
        ]);

        LecturerQuestion::create([
            'question' => 'Setiap unit/bagian memberikan pelayanan dengan kredibel sesuai SOP',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'lecturer_element_id' => 2,
        ]);
    }
}
