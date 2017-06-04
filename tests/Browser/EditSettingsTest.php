<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Tests\Browser\Pages\SettingsPage;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Locale;
use App\Language;
use App\User;

class EditSettingsTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_edit_settings()
    {
        factory(Locale::class)->create([
            'code' => 'en-US',
            'name' => 'English (US)',
        ]);

        $user = factory(User::class)->make();
        $user->locale()->associate(factory(Locale::class)->create([
            'code' => 'id-ID',
            'name' => 'Bahasa Indonesia',
        ]));
        $user->save();

        $user->languages()->attach(factory(Language::class)->create([
            'code' => 'id-ID',
            'name' => 'Bahasa Indonesia',
        ]));

        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->loginAs($user)
                ->visit(new SettingsPage)
                ->assertTitleContains('Pengaturan')
                ->keys('#settingsForm .search.dropdown .search', 'English')
                ->pause(500)
                ->keys('#settingsForm .search.dropdown .search', '{enter}')
                ->press('Simpan')
                ->assertPathIs('/my/settings')
                ->assertTitleContains('Settings');
        });
    }
}
