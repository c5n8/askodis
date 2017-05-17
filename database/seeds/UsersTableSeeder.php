<?php

use App\User;
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
    }
}
