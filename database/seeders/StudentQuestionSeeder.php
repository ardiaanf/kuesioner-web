<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudentQuestion;

class StudentQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentQuestion::create([
            'question' => 'Rencana materi dan tujuan mata kuliah diberikan di awal perkuliahan]',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'student_element_id' => 1,
        ]);

        StudentQuestion::create([
            'question' => 'Dosen datang tepat waktu & mengajar sesuai waktu yang terjadwal',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'student_element_id' => 1,
        ]);

        StudentQuestion::create([
            'question' => 'Diadakan diskusi & tanya jawab',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'student_element_id' => 1,
        ]);

        StudentQuestion::create([
            'question' => 'Manfaat soal latihan dalam menambah pemahaman mata kuliah ini',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'student_element_id' => 1,
        ]);

        StudentQuestion::create([
            'question' => 'Kesesuaian evaluasi (tugas dan Quiz) dengan materi yang diajarkan',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'student_element_id' => 1,
        ]);

        StudentQuestion::create([
            'question' => 'Pelaksanaan praktikum tepat waktu dan sesuai dengan waktu yang terjadwal',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'student_element_id' => 2,
        ]);

        StudentQuestion::create([
            'question' => 'Praktikum menambah pemahaman teori dan ketrampilan waktu yang terjadwal',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'student_element_id' => 2,
        ]);

        StudentQuestion::create([
            'question' => 'Setiap percobaan/praktikum sinergi dengan materi yang diajarkan saat teori',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'student_element_id' => 2,
        ]);

        StudentQuestion::create([
            'question' => 'Dosen selalu datang setiap praktikum',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'student_element_id' => 2,
        ]);

        StudentQuestion::create([
            'question' => 'Dosen menjelaskan arah dan tujuan dalam setiap percobaan]',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'student_element_id' => 2,
        ]);

        StudentQuestion::create([
            'question' => 'Visi, misi, tujuan dan strategi Politeknik Negeri Banyuwangi telah disosialisasikan secara jelas melalui berbagai kegiatan dan/atau media',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'student_element_id' => 3,
        ]);

        StudentQuestion::create([
            'question' => 'Visi, misi, tujuan dan strategi Politeknik Negeri Banyuwangi telah disosialisasikan secara berkala melalui berbagai kegiatan dan/atau media',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'student_element_id' => 3,
        ]);

        StudentQuestion::create([
            'question' => 'Mahasiswa mengetahui struktur organisasi Perguruan Tinggi',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'student_element_id' => 4,
        ]);

        StudentQuestion::create([
            'question' => 'Setiap unit/bagian memberikan pelayanan dengan terpercaya sesuai SOP',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'student_element_id' => 4,
        ]);

        StudentQuestion::create([
            'question' => 'Setiap unit/bagian memberikan pelayanan dengan terbuka',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'student_element_id' => 4,
        ]);

        StudentQuestion::create([
            'question' => 'Setiap unit/bagian memberikan pelayanan dengan jujur, disiplin, dan responsif',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'student_element_id' => 4,
        ]);

        StudentQuestion::create([
            'question' => 'Setiap unit/bagian memberikan pelayanan dengan bertanggung jawab',
            'min_range' => 1,
            'max_range' => 4,
            'label' => implode(',', ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju']),
            'student_element_id' => 4,
        ]);
    }
}
