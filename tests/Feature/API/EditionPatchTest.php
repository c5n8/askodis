<?php

namespace Tests\Feature\API;

use App\Answer;
use App\Edition;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditionPatchTest extends TestCase
{
    use DatabaseMigrations;

    function test_edition_patch()
    {
        $answer = factory(Answer::class)->create();
        $edition = factory(Edition::class)->make();
        $edition->editable()->associate($answer);
        $edition->save();

        $response = $this
            ->actingAs($answer->user, 'api')
            ->json(
                'PATCH',
                '/api/editions/' . $edition->id,
                [
                    'status' => 'accepted',
                ]
            );

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'accepted',
            ]);
    }
}
