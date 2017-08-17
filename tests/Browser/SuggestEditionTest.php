<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Tests\Browser\Pages\QuestionPage;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Answer;

class SuggestEditionTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_suggest_edition()
    {
        $this->browse(function ($first, $second) {
            $first
                ->loginAs(factory(User::class)->create())
                ->visit(new QuestionPage);

            $answer = Answer::first();

            $second
                ->loginAs($answer->user)
                ->visit('/')
                ->waitFor('#notificationMenu')
                ->assertDontSeeIn('#notificationMenu', '1');

            $first
                ->press('#answer-' . $answer->id . ' .more')
                ->click('#answer-' . $answer->id . ' .more .suggest')
                ->whenAvailable('.suggestion.modal', function ($form){
                    $form
                        ->type('body', 'Edited answer')
                        ->press('Post Edit Suggestion');
                })
                ->waitUntilMissing('.suggestion.modal')
                ->assertSee('Sent!');

            $second
                ->assertSeeIn('#notificationMenu', '1');
        });
    }
}
