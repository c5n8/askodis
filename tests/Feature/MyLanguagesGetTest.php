<?php

namespace Tests\Feature\API;

use App\Language;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyLanguagesGetTest extends TestCase
{
    use RefreshDatabase;

    function test_my_languages_get()
    {
        $languages = Language::factory()->count(2)->create();
        $user = User::factory()->create();
        $user->languages()->sync($languages);

        $response = $this
            ->actingAs($user, 'api')
            ->json('GET', '/api/my/languages');

        $response
            ->assertStatus(200)
            ->assertJson($user->languages->toArray());
    }
}
