<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Language;
use App\Edition;
use App\Question;
use App\User;

class ResponseSuggestEditTest extends DuskTestCase
{
    use DatabaseMigrations;

    function testExample()
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
        | Mock Answer
        |--------------------------------------------------------------------------        |
        */
        $user = factory(User::class)->create();

        $answer = $question->answers()->make();
        $answer->question()->associate($question);
        $answer->user()->associate($user);
        $answer->save();

        $translation = $answer->translations()->make();
        $translation->translatable()->associate($answer);
        $translation->language()->associate($language);
        $translation->save();

        $edition = factory(Edition::class)->make();
        $edition->user()->associate($user);
        $edition->translation()->associate($translation);
        $edition->save();

        /*
        |--------------------------------------------------------------------------
        | Mock Edit Suggestion
        |--------------------------------------------------------------------------        |
        */
        $edition = factory(Edition::class)->make();
        $edition->status = 'pending';
        $edition->translation()->associate($translation);
        $edition->save();

        $this->browse(function ($first, $second) use ($edition) {
            $first
                ->loginAs($edition->user)
                ->visit('/')
                ->assertDontSeeIn('#notificationMenu', '1');

            $second
                ->loginAs($edition->translation->translatable->user)
                ->visit('/edits/' . $edition->id)
                ->assertPathIs('/edits/' . $edition->id)
                ->press('Accept')
                ->waitForText('Accepted')
                ->assertSee('Accepted');


            $first->assertSeeIn('#notificationMenu', '1');
        });
    }
}
