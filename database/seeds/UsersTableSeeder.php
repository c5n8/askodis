<?php

use App\User;
use App\Language;
use App\Locale;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    function run()
    {
        DB::table('users')->delete();

        $locale = Locale::where('code', 'id-ID')->first();

        $user = factory(User::class)->make([
            'name' => 'Developer',
            'email' => 'dev@askodis.com',
            'password' => bcrypt('12345678'),
        ]);
        $user->locale()->associate($locale);
        $user->save();

        $languages = Language::all();
        $user->languages()->sync($languages);

        $user = factory(User::class)->create([
            'name' => 'Engineer',
            'email' => 'engineer@askodis.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
