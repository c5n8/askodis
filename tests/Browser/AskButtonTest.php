<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\QuestionPage;
use Tests\DuskTestCase;

class AskButtonTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_ask_button()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(factory(User::class)->create())
                ->visit(new QuestionPage)
                ->assertSee('0 People ask')

                ->press('Ask')
                ->waitForText('Asked')
                ->assertSee('1 People ask')

                ->press('Asked')
                ->waitForText('Ask')
                ->assertSee('0 People ask');
        });
    }
}
