<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Major;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Major::create([
            'name' => 'Multimedia',
        ]);

        Major::create([
            'name' => 'Teknik Informatika',
        ]);

        Major::create([
            'name' => 'Sistem Informasi',
        ]);
    }
}
