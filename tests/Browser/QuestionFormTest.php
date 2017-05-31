<?php

namespace Tests\Browser;

use App\Edition;
use App\Language;
use App\User;
use App\Tag;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuestionFormTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_question_form()
    {
        $user     = factory(User::class)->create();
        $language = factory(Language::class)->create();
        $user->languages()->attach($language, ['is_preferred' => true]);

        $tag = factory(Tag::class)->create();

        $edition = factory(Edition::class)->make(['text' => 'tag 1']);
        $edition->editable()->associate($tag);
        $edition->language()->associate($language);
        $edition->save();

        $this->browse(function (Browser $browser) use ($user) {
            config(['scout.driver' => 'algolia']);

            $browser
                ->loginAs($user)
                ->visit('/')
                ->pause(1000)
                ->type('search', 'Gibberish')
                ->waitFor('.results')
                ->press('Write New Question')
                ->waitFor('#questionForm')
                ->keys('#questionForm [name="body"]', ' question?')
                ->pause(500)
                ->keys('#questionForm [name="detail"]', 'Here is the detail');

                $tags = ['tag 1', 'tag 2', 'tag 3'];

                foreach ($tags as $tag) {
                    $browser
                        ->keys('#questionForm .tags .search', $tag)
                        ->pause(500)
                        ->keys('#questionForm .tags .search', '{enter}');
                }

                $browser
                    ->press('Post Question')
                    ->waitUntilMissing('#questionForm')
                    ->assertPathIs('/gibberish-question')
                    ->assertSee('Gibberish question?')
                    ->assertSee('Here is the detail')
                    ->assertSee('1 People ask');

                foreach ($tags as $tag) {
                    $browser->assertSee('Here is the detail', $tag);
                }
        });
    }
}
