<?php

use App\Language;
use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    function run()
    {
        DB::table('languages')->delete();

        factory(Language::class)->create([
            'code' => 'id',
            'name' => 'Bahasa Indonesia',
        ]);

        factory(Language::class)->create([
            'code' => 'en',
            'name' => 'English',
        ]);
    }
}
