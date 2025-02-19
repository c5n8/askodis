<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            LanguagesTableSeeder::class,
            LocalesTableSeeder::class,
            UsersTableSeeder::class,
            QuestionsTableSeeder::class,
        ]);
    }
}
