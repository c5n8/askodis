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

        $edition = factory(Edition::class)->make(['text' => 'Is this an example of question?']);
        $edition->editable()->associate($question);
        $edition->language()->associate($language);
        $edition->save();

        /*
        |--------------------------------------------------------------------------
        | Mock Detail
        |--------------------------------------------------------------------------        |
        */
        $detail = $question->detail()->save($question->detail()->make());

        $edition = factory(Edition::class)->make(['text' => 'Here is the detail of the question']);
        $edition->editable()->associate($detail);
        $edition->language()->associate($language);
        $edition->save();

        /*
        |--------------------------------------------------------------------------
        | Mock Tag
        |--------------------------------------------------------------------------        |
        */
        $tag = factory(Tag::class)->create();

        $edition = factory(Edition::class)->make(['text' => 'tag']);
        $edition->editable()->associate($tag);
        $edition->language()->associate($language);
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

        $edition = factory(Edition::class)->make(['text' => 'Here is my answer']);
        $edition->editable()->associate($answer);
        $edition->language()->associate($language);
        $edition->user()->associate($answer->user);
        $edition->save();

        return 'is-this-an-example-of-question';
    }
}
