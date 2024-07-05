<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LecturerEmploymentStatus;

class LecturerEmploymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            'Permanent',
            'Contract',
            'Temporary',
            'Internship',
        ];

        foreach ($statuses as $status) {
            LecturerEmploymentStatus::create([
                'name' => $status,
            ]);
        }
    }
}
