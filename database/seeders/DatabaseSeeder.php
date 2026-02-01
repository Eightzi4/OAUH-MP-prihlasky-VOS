<?php

namespace Database\Seeders;

use App\Models\StudyProgram;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        StudyProgram::create([
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
    }
}
