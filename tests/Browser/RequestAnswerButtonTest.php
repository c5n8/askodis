<?php

namespace Tests\Browser;

use App\Edition;
use App\Slug as Question;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RequestAnswerButtonTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_request_answer_button()
    {
        factory(Edition::class)->states('question')->create();
        $question = Question::first();

        $this->browse(function (Browser $browser) use ($question) {
            $browser
                ->loginAs(factory(User::class)->create())
                ->visit($question->slug)
                ->assertSee('0 Answer requests')

                ->press('#requestAnswerButton')
                ->waitForText('1 Answer requests')
                ->assertSee('1 Answer requests')

                ->press('#requestAnswerButton')
                ->waitForText('0 Answer requests')
                ->assertSee('0 Answer requests');
        });
    }
}
