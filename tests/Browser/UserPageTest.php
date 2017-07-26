<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\QuestionPage;
use Tests\DuskTestCase;

class UserPageTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_visit_user_page()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();

            $browser
                ->visit('/@'.$user->username)
                ->assertPathIs('/@'.$user->username)
                ->assertTitleContains($user->name)
                ->assertSee($user->username);
        });
    }
}
