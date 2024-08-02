<?php

namespace Database\Seeders;

use App\Models\AcadStaffQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcadStaffQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AcadStaffQuestion::create([
            'question' => 'Visi, Misi, Tujuan Politeknik Negeri Banyuwangi telah disosialisasikan secara jelas melalui berbagai kegiatan dan/atau media',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'acad_staff_element_id' => 1,
        ]);

        AcadStaffQuestion::create([
            'question' => 'Visi, Misi, Tujuan Politeknik Negeri Banyuwangi telah disosialisasikan secara berkala melalui berbagai kegiatan dan/atau media',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'acad_staff_element_id' => 1,
        ]);

        AcadStaffQuestion::create([
            'question' => 'Tenaga pendidik telah mengimplementasikan Visi, Misi, Tujuan, dan Strategi sesuai tupoksi',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'acad_staff_element_id' => 1,
        ]);

        AcadStaffQuestion::create([
            'question' => 'Tenaga Kependidikan telah mengetahui struktur organisasi di Politeknik Negeri Banyuwangi dengan jelas',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'acad_staff_element_id' => 2,
        ]);

        AcadStaffQuestion::create([
            'question' => 'Tenaga Kependidikan telah mengetahui tugas pokok dan fungsi masing-masing jabatan dengan jelas',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'acad_staff_element_id' => 2,
        ]);

        AcadStaffQuestion::create([
            'question' => 'Tenaga Kependidikan mendapatkan kejelasan mengenai kewenangan dalam mengatasi permasalahan yang terjadi di Politeknik Negeri Banyuwangi',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'acad_staff_element_id' => 2,
        ]);
    }
}
