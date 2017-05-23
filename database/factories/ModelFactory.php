<?php

use App\Answer;
use App\Detail;
use App\Edition;
use App\Language;
use App\Question;
use App\Slug;
use App\Tag;
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
        'code' => $faker->languageCode,
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

$factory->state(Translation::class, 'answer', function (Generator $faker) {
    $answer = factory(Answer::class)->create();

    return [
        'translatable_type' => 'answer',
        'translatable_id'   => function () use ($answer) {
            return $answer->id;
        },
        'language_id' => function () {
            return Language::first()->id;
        },
    ];
});

$factory->state(Translation::class, 'tag', function (Generator $faker) {
    $language = Language::first();

    if (is_null($language)) {
        $language = factory(Language::class)->create();
    }

    return [
        'translatable_type' => 'tag',
        'translatable_id'   => function () {
            return factory(Tag::class)->create();
        },
        'language_id' => function () use ($language) {
            return $language->id;
        },
    ];
});

$factory->define(Edition::class, function (Generator $faker) {
    return [
        'text' => $faker->paragraph,
    ];
});

$factory->state(Edition::class, 'question', function (Generator $faker) {
    return [
        'text' => str_replace('.', '?', $faker->sentence),
        'translation_id' => function () {
            return factory(Translation::class)->states('question')->create()->id;
        },
    ];
});

$factory->state(Edition::class, 'detail', function (Generator $faker) {
    return [
        'text'           => $faker->paragraph,
        'translation_id' => function () {
            return factory(Translation::class)->states('detail')->create()->id;
        },
    ];
});

$factory->state(Edition::class, 'answer', function (Generator $faker) {
    return [
        'text'           => $faker->paragraph(10),
        'translation_id' => function () {
            return factory(Translation::class)->states('answer')->create()->id;
        },
    ];
});

$factory->state(Edition::class, 'tag', function (Generator $faker) {
    return [
        'text'           => $faker->word,
        'translation_id' => function () {
            return factory(Translation::class)->states('tag')->create()->id;
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

$factory->define(Answer::class, function (Generator $faker) {
    return [
        'question_id' => function () {
            return factory(Edition::class)->states('question')->create()->translation->translatable->id;
        },
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

$factory->define(Tag::class, function (Generator $faker) {
    return [];
});
