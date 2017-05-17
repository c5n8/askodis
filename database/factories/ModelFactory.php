<?php

use App\Detail;
use App\Edition;
use App\Language;
use App\Question;
use App\Translation;
use App\User;
use Faker\Generator;

$factory->define(User::class, function (Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Question::class, function (Generator $faker) {
    return [];
});

$factory->define(Language::class, function (Generator $faker) {
    return [
        'name' => $faker->country,
    ];
});

$factory->define(Translation::class, function (Generator $faker) {
    return [];
});

$factory->define(Edition::class, function (Generator $faker) {
    return [
        'text' => $faker->sentence,
    ];
});

$factory->define(Detail::class, function (Generator $faker) {
    return [];
});
