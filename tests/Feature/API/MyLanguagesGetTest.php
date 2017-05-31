<?php

namespace Tests\Feature\API;

use App\Language;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MyLanguagesGetTest extends TestCase
{
    use DatabaseMigrations;

    function test_my_languages_get()
    {
        $languages = factory(Language::class, 2)->create();
        $user = factory(User::class)->create();
        $user->languages()->sync($languages);
        $user->languages()->updateExistingPivot($languages->first()->id, ['is_preferred' => true]);

        $response = $this
            ->actingAs($user, 'api')
            ->json('GET', '/api/my/languages');

        $response
            ->assertStatus(200)
            ->assertJson($user->languages->toArray());
    }
}
