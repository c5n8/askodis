<?php

namespace Tests\Browser\Pages;

use App\Edition;
use App\Language;
use App\Question;
use App\Tag;
use App\User;
use Laravel\Dusk\Page;

class QuestionPage extends Page
{
    function url()
    {
        $language = factory(Language::class)->create();

        /*
        |--------------------------------------------------------------------------
        | Mock Question
        |--------------------------------------------------------------------------        |
        */
        $question = factory(Question::class)->create();

        $translation = $question->translations()->make();
        $translation->translatable()->associate($question);
        $translation->language()->associate($language);
        $translation->save();

        $edition = factory(Edition::class)->make(['text' => 'Is this an example of question?']);
        $edition->translation()->associate($translation);
        $edition->save();

        /*
        |--------------------------------------------------------------------------
        | Mock Detail
        |--------------------------------------------------------------------------        |
        */
        $detail = $question->detail()->make();
        $detail->question()->associate($question);
        $detail->save();

        $translation = $detail->translations()->make();
        $translation->translatable()->associate($detail);
        $translation->language()->associate($language);
        $translation->save();

        $edition = factory(Edition::class)->make(['text' => 'Here is the detail of the question']);
        $edition->translation()->associate($translation);
        $edition->save();

        /*
        |--------------------------------------------------------------------------
        | Mock Tag
        |--------------------------------------------------------------------------        |
        */
        $tag = factory(Tag::class)->create();

        $translation = $tag->translations()->make();
        $translation->translatable()->associate($tag);
        $translation->language()->associate($language);
        $translation->save();

        $edition = factory(Edition::class)->make(['text' => 'tag']);
        $edition->translation()->associate($translation);
        $edition->save();

        $question->tags()->attach($tag);

        /*
        |--------------------------------------------------------------------------
        | Mock Answer
        |--------------------------------------------------------------------------        |
        */
        $user = factory(User::class)->create(['name' => 'John Doe']);

        $answer = $question->answers()->make();
        $answer->question()->associate($question);
        $answer->user()->associate($user);
        $answer->save();

        $translation = $answer->translations()->make();
        $translation->translatable()->associate($answer);
        $translation->language()->associate($language);
        $translation->save();

        $edition = factory(Edition::class)->make(['text' => 'Here is my answer']);
        $edition->translation()->associate($translation);
        $edition->save();

        return 'is-this-an-example-of-question';
    }
}
