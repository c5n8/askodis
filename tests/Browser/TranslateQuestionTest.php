<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Tests\Browser\Pages\QuestionPage;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Language;
use App\Tag;

class TranslateQuestionTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_translate_question()
    {
        $languages = factory(Language::class, 2)->create();
        $user = factory(User::class)->create();
        $user->languages()->sync($languages);

        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->loginAs($user)
                ->visit(new QuestionPage)
                ->press('#questionMenu .more')
                ->click('#questionMenu .more .translate')
                ->waitFor('#questionTranslationForm')
                ->pause(500)
                ->click('#questionTranslationForm [name="body"]')
                ->keys('#questionTranslationForm [name="body"]', 'Translated question?')
                ->pause(500)
                ->keys('#questionTranslationForm [name="detail"]', 'Translated detail')
                ->pause(500)
                ->keys('#questionTranslationForm [name="tags[0][body]"]', 'Translated tag')
                ->press('Post Translation')
                ->waitUntilMissing('#questionTranslationForm')
                ->assertPathIs('/translated-question')
                ->assertSee('Translated question?')
                ->assertSee('Translated detail')
                ->assertSee('Translated tag');
        });
    }
}
