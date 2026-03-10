<?php

namespace Database\Seeders;

use App\Models\StudyProgram;
use App\Models\Application;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Hlavní Admin',
            'email' => 'admin@oauh.cz',
            'password' => Hash::make('admin123'),
            'role' => 'Hlavní administrátor',
        ]);

        $program = StudyProgram::create([
            'name' => 'Ekonomicko-právní činnost',
            'code' => '63-41-N/04',
            'degree' => 'DiS. (Diplomovaný specialista)',
            'form' => 'Prezenční',
            'length' => '3 roky',
            'tuition_fee' => '2 500 Kč / rok',
            'description' => 'Komplexní vzdělávací program zaměřený na propojení ekonomických znalostí s právním povědomím. Absolventi získají kvalifikaci pro práci ve státní správě, v právních kancelářích nebo v managementu firem.',
            'image_path' => 'https://www.oauh.cz/content/subjects/6.jpg',
            'is_active' => true,
        ]);

        $faker = Faker::create('cs_CZ');

        for ($i = 0; $i < 25; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'role' => 'Uchazeč',
            ]);

            $status = $faker->randomElement(['draft', 'submitted']);
            $submittedAt = $status === 'submitted' ? $faker->dateTimeBetween('-1 month', 'now') : null;
            $appNumber = $status === 'submitted' ? '2026' . str_pad($i + 1, 4, '0', STR_PAD_LEFT) : null;

            Application::create([
                'user_id' => $user->id,
                'study_program_id' => $program->id,
                'status' => $status,
                'application_number' => $appNumber,
                'submitted_at' => $submittedAt,
                'created_at' => $faker->dateTimeBetween('-2 months', '-1 month'),
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $user->email,
                'phone' => $faker->phoneNumber,
                'gender' => $faker->randomElement(['Muž', 'Žena']),
                'birth_date' => $faker->dateTimeBetween('-25 years', '-18 years')->format('Y-m-d'),
                'street' => $faker->streetAddress,
                'city' => $faker->city,
                'zip' => str_replace(' ', '', $faker->postcode),
                'country' => 'Česká republika',
            ]);
        }
    }
}
