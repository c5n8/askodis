<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Tests\Browser\Pages\QuestionPage;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Language;
use App\User;
use App\Answer;

class RequestAnswerTranslationTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_request_answer_translation()
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
                ->click('#answer-' . $answer->id . ' .more .request.translation')
                ->whenAvailable('.request.translation.modal', function ($form){
                    $form
                        ->press('Request Translation');
                })
                ->waitUntilMissing('.request.translation.modal')
                ->assertSee('Sent!');
        });
    }
}
