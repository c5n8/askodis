<?php

namespace Database\Seeders;

use App\Models\Locale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('locales')->delete();

        Locale::create([
            'code' => 'en-US',
            'name' => 'English (US)',
        ]);

        Locale::create([
            'code' => 'id-ID',
            'name' => 'Bahasa Indonesia',
        ]);
    }
}
