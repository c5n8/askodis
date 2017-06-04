<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\SettingsPage;
use Tests\DuskTestCase;
use App\User;

class SettingsPageTest extends DuskTestCase
{
    use DatabaseMigrations;

    function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(factory(User::class)->create())
                ->visit(new SettingsPage)
                ->assertTitleContains('Settings');
        });
    }
}
