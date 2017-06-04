<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Language;
use App\Answer;
use App\Edition;
use App\Question;
use App\User;

class ResponseSuggestedEditionTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_response_suggested_edition_test()
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
        | Mock Answer
        |--------------------------------------------------------------------------        |
        */
        $answer = $question->answers()->save(factory(Answer::class)->create());

        $edition = factory(Edition::class)->make(['text' => 'Here is my answer']);
        $edition->editable()->associate($answer);
        $edition->language()->associate($language);
        $edition->user()->associate($answer->user);
        $edition->save();

        /*
        |--------------------------------------------------------------------------
        | Mock Edit Suggestion
        |--------------------------------------------------------------------------        |
        */
        $edition = factory(Edition::class)->make();
        $edition->status = 'pending';
        $edition->editable()->associate($answer);
        $edition->language()->associate($language);
        $edition->save();

        $this->browse(function ($first, $second) use ($edition, $answer) {
            $first
                ->loginAs($edition->user)
                ->visit('/')
                ->assertDontSeeIn('#notificationMenu', '1');

            $second
                ->loginAs($answer->user)
                ->visit('/editions/' . $edition->id)
                ->assertPathIs('/editions/' . $edition->id)
                ->press('Accept')
                ->waitForText('Accepted')
                ->assertSee('Accepted');


            $first->assertSeeIn('#notificationMenu', '1');
        });
    }
}
