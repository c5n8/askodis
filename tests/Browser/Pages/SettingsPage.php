<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class SettingsPage extends BasePage
{
    function url()
    {
        return '/my/settings';
    }

    function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }
}
