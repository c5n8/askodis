<?php

namespace Tests\Feature\API\My\Language;

use App\Language;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GetMyLanguagesTest extends TestCase
{
    use DatabaseMigrations;

    function test_get_my_languages()
    {
        $user = factory(User::class)->create();
        $languages = factory(Language::class, 2)->create();
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
