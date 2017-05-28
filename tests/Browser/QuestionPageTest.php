<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\QuestionPage;
use Tests\DuskTestCase;

class QuestionPageTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_visit_question_page()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(factory(User::class)->create())
                ->visit(new QuestionPage)
                ->assertPathIs('/is-this-an-example-of-question')
                ->assertTitleContains('Is this an example of question?')
                ->assertSee('Is this an example of question?')
                ->assertSee('Here is the detail of the question')
                ->assertSee('tag')
                ->assertSee('1 Answers')
                ->assertSee('John Doe')
                ->assertSee('Here is my answer');
        });
    }
}
