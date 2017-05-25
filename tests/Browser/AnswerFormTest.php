<?php

namespace Tests\Browser;

use App\Edition;
use App\Slug as Question;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AnswerFormTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_answer_form()
    {
        factory(Edition::class)->states('question')->create();
        $question = Question::first();

        $this->browse(function (Browser $browser) use ($question) {
            $input = factory(Edition::class)->make();

            $browser
                ->loginAs(factory(User::class)->create())
                ->visit($question->slug)

                ->press('#answerButton')
                ->waitFor('#answerForm')
                ->keys('#answerForm textarea', $input->text)
                ->press('#answerForm .button')
                ->waitUntilMissing('#answerForm')
                ->assertSee('Your Answer')
                ->assertSee($input->text);

            $input = factory(Edition::class)->make();

            $browser
                ->press('#answerButton')
                ->waitFor('#answerForm')
                ->keys('#answerForm textarea', $input->text)
                ->press('#answerForm .button')
                ->waitUntilMissing('#answerForm')
                ->assertSee($input->text);
        });
    }
}
