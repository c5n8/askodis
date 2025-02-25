<?php

namespace Database\Seeders;

use App\Locale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalesTableSeeder extends Seeder
{
    function run()
    {
        DB::table('locales')->delete();

        Locale::factory()->create([
            'code' => 'en-US',
            'name' => 'English (US)',
        ]);

        Locale::factory()->create([
            'code' => 'id-ID',
            'name' => 'Bahasa Indonesia',
        ]);
    }
}
