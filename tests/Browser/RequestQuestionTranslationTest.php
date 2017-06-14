<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Pages\QuestionPage;
use App\User;
use App\Language;

class RequestQuestionTranslationTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_request_question_translation()
    {
        $languages = factory(Language::class, 2)->create();
        $user = factory(User::class)->create();
        $user->languages()->sync($languages);

        $this->browse(function (Browser $browser) use ($user, $languages) {
            $browser
                ->loginAs($user)
                ->visit(new QuestionPage)
                ->press('#questionMenu .more')
                ->assertSee('Request Translation')
                ->click('#questionMenu .more .request.translation')
                ->waitFor('#questionTranslationRequestForm')
                ->pause(500)
                ->press('Send Request')
                ->waitUntilMissing('#questionTranslationRequestForm')
                ->assertSee('Sent!')
                ;
        });
    }
}
