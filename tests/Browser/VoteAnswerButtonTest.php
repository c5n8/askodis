<?php

namespace Tests\Browser;

use App\Answer;
use App\Edition;
use App\Slug as Question;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class VoteAnswerButtonTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_vote_answer_button()
    {
        factory(Edition::class)->states('answer')->create();
        $question = Question::first();

        $this->browse(function ($first, $second) use ($question) {
            $first
                ->loginAs(factory(User::class)->create())
                ->visit($question->slug)
                ->assertSee('0 Votes')

                ->press('#answer-1 .vote.button')
                ->waitForText('1 Votes')
                ->assertSee('1 Votes')

                ->press('#answer-1 .vote.button')
                ->waitForText('0 Votes')
                ->assertSee('0 Votes');

            $second
                ->loginAs(Answer::first()->user)
                ->visit('/')
                ->assertSeeIn('#notificationMenu', '1');
        });
    }
}
