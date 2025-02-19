<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('languages')->delete();

        Language::create([
            'code' => 'id',
            'name' => 'Bahasa Indonesia',
        ]);

        Language::create([
            'code' => 'en',
            'name' => 'English',
        ]);
    }
}
