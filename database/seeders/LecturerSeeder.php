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
        $faker = \Faker\Factory::create('id_ID');
        Lecturer::create([
            'name' => 'Esa Rindy Cardias, S.Pr., M.SC',
            'reg_number' => $faker->unique()->regexify('D[0-9]{3}'),
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'work_period' => 2020,
            'lecturer_employment_status_id' => 1,
        ]);

        Lecturer::create([
            'name' => 'Firda Rahma Amalia SE., MM',
            'reg_number' => $faker->unique()->regexify('D[0-9]{3}'),
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'work_period' => 2022,
            'lecturer_employment_status_id' => 2,
        ]);

        Lecturer::create([
            'name' => 'Kanom, S.Pd., M.Par',
            'reg_number' => $faker->unique()->regexify('D[0-9]{3}'),
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'work_period' => 2022,
            'lecturer_employment_status_id' => 2,
        ]);

        Lecturer::create([
            'name' => 'Randhi Nanang Darmawan, S.Si., M.Si',
            'reg_number' => $faker->unique()->regexify('D[0-9]{3}'),
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'work_period' => 2022,
            'lecturer_employment_status_id' => 2,
        ]);
    }
}
