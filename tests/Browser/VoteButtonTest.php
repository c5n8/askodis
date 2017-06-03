<?php

namespace Tests\Browser;

use App\Answer;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Pages\QuestionPage;

class VoteButtonTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_vote_button_test()
    {
        $this->browse(function ($first, $second) {
            $first
                ->loginAs(factory(User::class)->create())
                ->visit(new QuestionPage)
                ->assertSee('No vote yet');

            $second
                ->loginAs(Answer::first()->user)
                ->visit('/')
                ->assertDontSeeIn('#notificationMenu', '1');

            $first->press('Vote')
                ->waitForText('Voted')
                ->assertSee('1 Vote');

            $second->assertSeeIn('#notificationMenu', '1');

            $first->press('Voted')
                ->waitForText('Vote')
                ->assertSee('No vote yet');
        });
    }
}
