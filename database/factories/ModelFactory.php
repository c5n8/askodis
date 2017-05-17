<?php

use App\Detail;
use App\Edition;
use App\Language;
use App\Question;
use App\Slug;
use App\Translation;
use App\User;
use Faker\Generator;

$factory->define(User::class, function (Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
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
    return [
        'language_id' => function () {
            return factory(Language::class)->create()->id;
        },
    ];
});

$factory->state(Translation::class, 'question', function (Generator $faker) {
    return [
        'translatable_type' => 'question',
        'translatable_id'   => function () {
            return factory(Question::class)->create()->id;
        },
    ];
});

$factory->state(Translation::class, 'detail', function (Generator $faker) {
    $detail = factory(Detail::class)->create();

    return [
        'translatable_type' => 'detail',
        'translatable_id'   => function () use ($detail) {
            return $detail->id;
        },
        'language_id' => function () {
            return Language::first()->id;
        },
    ];
});

$factory->define(Edition::class, function (Generator $faker) {
    return [
        'text' => $faker->sentence,
    ];
});

$factory->state(Edition::class, 'question', function (Generator $faker) {
    return [
        'translation_id' => function () {
            return factory(Translation::class)->states('question')->create()->id;
        },
    ];
});

$factory->state(Edition::class, 'detail', function (Generator $faker) {
    return [
        'translation_id' => function () {
            return factory(Translation::class)->states('detail')->create()->id;
        },
    ];
});

$factory->define(Detail::class, function (Generator $faker) {
    return [
        'question_id' => function () {
            return factory(Edition::class)->states('question')->create()->translation->translatable->id;
        },
    ];
});
