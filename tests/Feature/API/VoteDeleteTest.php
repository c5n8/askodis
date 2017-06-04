<?php

namespace Tests\Feature\API;

use App\Answer;
use App\User;
use App\Vote;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class VoteDeleteTest extends TestCase
{
    use DatabaseMigrations;

    function test_vote_delete()
    {
        $answer = factory(Answer::class)->create();
        $vote = $answer->votes()->save(factory(Vote::class)->make());

        $response = $this
            ->actingAs($vote->user, 'api')
            ->json('DELETE', 'api/votes/' . $vote->id);

        $response->assertStatus(204);
    }
}
