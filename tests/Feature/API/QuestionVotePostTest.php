<?php

namespace Tests\Feature\API;

use App\Slug;
use App\User;
use App\Vote;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class QuestionVotePostTest extends TestCase
{
    use DatabaseMigrations;

    function test_question_vote_post()
    {
        $slug = factory(Slug::class)->create();

        $response = $this
            ->actingAs(factory(User::class)->create(), 'api')
            ->json('POST', '/api/questions/' . $slug->id . '/votes');

        $response
            ->assertStatus(200)
            ->assertJson(Vote::first()->toArray());
    }
}
