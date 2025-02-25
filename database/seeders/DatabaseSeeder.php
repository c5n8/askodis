<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LanguagesTableSeeder::class);
        $this->call(LocalesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(QuestionsTableSeeder::class);
    }
}
