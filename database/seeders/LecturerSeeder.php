<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lecturer;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lecturer::create([
            'name' => 'Lecturer',
            'reg_number' => 'L001',
            'email' => 'lecturer@mail.com',
            'password' => bcrypt('password'),
            'work_period' => 2020,
            'lecturer_employment_status_id' => 1,
        ]);

        Lecturer::create([
            'name' => 'Lecturer 2',
            'reg_number' => 'L002',
            'email' => 'lecturer@example.com',
            'password' => bcrypt('password'),
            'work_period' => 2022,
            'lecturer_employment_status_id' => 2,
        ]);
    }
}
