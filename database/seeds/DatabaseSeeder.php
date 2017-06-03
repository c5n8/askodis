<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    function run()
    {
        $this->call(LanguagesTableSeeder::class);
        $this->call(LocalesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(QuestionsTableSeeder::class);
    }
}
