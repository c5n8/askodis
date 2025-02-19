<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Locale;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
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

        User::factory()->create([
            'name' => 'Engineer',
            'email' => 'engineer@askodis.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
