<?php

use App\User;
use App\Language;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    function run()
    {
        DB::table('users')->delete();

        $user = factory(User::class)->create([
            'name' => 'Developer',
            'email' => 'dev@askodis.com',
            'password' => bcrypt('12345678'),
        ]);
        $languages = factory(Language::class, 2)->create();
        $user->languages()->sync($languages);
        $user->languages()->updateExistingPivot($languages->first()->id, ['is_preferred' => true]);

        $user = factory(User::class)->create([
            'name' => 'Engineer',
            'email' => 'engineer@askodis.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
