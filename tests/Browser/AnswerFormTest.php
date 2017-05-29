<?php

namespace Tests\Browser;

use App\Edition;
use App\Question;
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
        $this->browse(function ($first, $second) {
            $input = factory(Edition::class)->make();

            $page = new QuestionPage;

            $second
                ->loginAs(factory(User::class)->create())
                ->visit($page)
                ->assertDontSeeIn('#notificationMenu', '1')
                ->press('Ask');

            $first
                ->loginAs(factory(User::class)->create())
                ->visit($page)
                ->press('Answer')
                ->waitFor('#answerForm')
                ->type('#answerForm textarea', $input->text)
                ->press('Post')
                ->waitUntilMissing('#answerForm')
                ->assertSee('Your Answer')
                ->assertSee($input->text)
                ->assertSee('All 2 Answers');

            $second->assertSeeIn('#notificationMenu', '1');

            $input = factory(Edition::class)->make();

            $first
                ->press('Edit Answer')
                ->waitFor('#answerForm')
                ->keys('#answerForm textarea', $input->text)
                ->press('Post')
                ->waitUntilMissing('#answerForm')
                ->assertSee($input->text);
        });
    }
}
