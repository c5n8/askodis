<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Tests\Browser\Pages\QuestionPage;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Language;
use App\Tag;

class RequestQuestionTranslationTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_request_question_translation()
    {
        $languages = factory(Language::class, 2)->create();
        $user = factory(User::class)->create();
        $user->languages()->sync($languages);

        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->loginAs($user)
                ->visit(new QuestionPage)
                ->waitFor('#questionMenu .more')
                ->press('#questionMenu .more')
                ->click('#questionMenu .more .request.translation')
                ->whenAvailable('#requestQuestionTranslationForm', function ($form){
                    $form->press('Request Translation');
                })
                ->waitUntilMissing('#requestQuestionTranslationForm')
                ->assertSee('Sent!');
        });
    }
}
