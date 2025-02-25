<?php

namespace Database\Seeders;

use App\User;
use App\Language;
use App\Locale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    function run()
    {
        DB::table('users')->delete();

        $locale = Locale::where('code', 'id-ID')->first();

        $user = User::factory()->make([
            'name' => 'Developer',
            'email' => 'dev@askodis.com',
            'password' => bcrypt('12345678'),
        ]);
        $user->locale()->associate($locale);
        $user->save();

        $languages = Language::all();
        $user->languages()->sync($languages);

        $user = User::factory()->create([
            'name' => 'Engineer',
            'email' => 'engineer@askodis.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
