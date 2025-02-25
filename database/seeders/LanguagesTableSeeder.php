<?php

namespace Database\Seeders;

use App\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{
    function run()
    {
        DB::table('languages')->delete();

        Language::factory()->create([
            'code' => 'id',
            'name' => 'Bahasa Indonesia',
        ]);

        Language::factory()->create([
            'code' => 'en',
            'name' => 'English',
        ]);
    }
}
