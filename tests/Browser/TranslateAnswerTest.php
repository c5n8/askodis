<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Tests\Browser\Pages\QuestionPage;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Answer;
use App\Language;
use App\Tag;

class TranslateAnswerTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_translate_answer()
    {
        $languages = factory(Language::class, 2)->create();
        $user = factory(User::class)->create();
        $user->languages()->sync($languages);

        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->loginAs($user)
                ->visit(new QuestionPage);

            $answer = Answer::first();

            $browser
                ->waitFor('#answer-' . $answer->id)
                ->click('#answer-' . $answer->id . ' .more')
                ->click('#answer-' . $answer->id . ' .more .translate')
                ->whenAvailable('.translation.modal', function ($form){
                    $form
                        ->type('body', 'Translated answer')
                        ->press('Post Translation');
                })
                ->waitUntilMissing('.translation.modal')
                ->assertSee('Sent!');
        });
    }
}
