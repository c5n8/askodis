<?php

use App\Answer;
use App\Detail;
use App\Edition;
use App\Language;
use App\Locale;
use App\Question;
use App\Slug;
use App\Tag;
use App\User;
use App\Vote;
use Faker\Generator;

$factory->define(User::class, function (Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'username'       => function (array $user) {
            return snake_case($user['name']) . str_random(8);
        },
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'locale_id'      => function () {
            return factory(Locale::class)->create()->id;
        }
    ];
});

$factory->define(Question::class, function (Generator $faker) {
    return [];
});

$factory->define(Language::class, function (Generator $faker) {
    return [
        'name' => $faker->country,
        'code' => $faker->languageCode,
    ];
});

$factory->define(Locale::class, function (Generator $faker) {
    return [
        'name' => $faker->country,
        'code' => $faker->languageCode,
    ];
});

$factory->define(Edition::class, function (Generator $faker) {
    return [
        'text' => $faker->paragraph,
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'language_id' => function () {
            return factory(Language::class)->create()->id;
        },
        'status' => 'accepted'
    ];
});

$factory->define(Detail::class, function (Generator $faker) {
    return [];
});

$factory->define(Answer::class, function (Generator $faker) {
    return [
        'question_id' => function () {
            return factory(Question::class)->create()->id;
        },
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

$factory->define(Tag::class, function (Generator $faker) {
    return [];
});

$factory->define(Vote::class, function (Generator $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

$factory->define(Slug::class, function (Generator $faker) {
    return [
        'text' => str_slug($faker->text),
        'question_id' => function () {
            return factory(Question::class)->create()->id;
        },
        'language_id' => function () {
            return factory(Language::class)->create()->id;
        },
    ];
});
