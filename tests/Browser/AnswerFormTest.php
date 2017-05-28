<?php

namespace Tests\Browser;

use App\Edition;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Pages\QuestionPage;

class AnswerFormTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_answer_form()
    {
        $this->browse(function (Browser $browser) {
            $input = factory(Edition::class)->make();

            $browser
                ->loginAs(factory(User::class)->create())
                ->visit(new QuestionPage)
                ->press('Answer')
                ->waitFor('#answerForm')
                ->type('#answerForm textarea', $input->text)
                ->press('Post')
                ->waitUntilMissing('#answerForm')
                ->assertSee('Your Answer')
                ->assertSee($input->text)
                ->assertSee('All 2 Answers');

            $input = factory(Edition::class)->make();

            $browser
                ->press('Edit Answer')
                ->waitFor('#answerForm')
                ->keys('#answerForm textarea', $input->text)
                ->press('Post')
                ->waitUntilMissing('#answerForm')
                ->assertSee($input->text);
        });
    }
}
