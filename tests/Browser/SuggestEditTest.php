<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Tests\Browser\Pages\QuestionPage;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class SuggestEditTest extends DuskTestCase
{
    use DatabaseMigrations;

    function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(factory(User::class)->create())
                ->visit(new QuestionPage)
                ->press('.more')
                ->click('.more .suggest')
                ->whenAvailable('.suggestion.modal', function ($form){
                    $form
                        ->type('body', 'Edited answer')
                        ->press('Post Edit Suggestion');
                })
                ->waitUntilMissing('.suggestion.modal')
                ->assertSee('Your edit suggestion is posted!');
        });
    }
}
