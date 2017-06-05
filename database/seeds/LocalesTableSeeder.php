<?php

use App\Locale;
use Illuminate\Database\Seeder;

class LocalesTableSeeder extends Seeder
{
    function run()
    {
        DB::table('locales')->delete();

        factory(Locale::class)->create([
            'code' => 'en-US',
            'name' => 'English (US)',
        ]);

        factory(Locale::class)->create([
            'code' => 'id-ID',
            'name' => 'Bahasa Indonesia',
        ]);
    }
}
