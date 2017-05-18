<?php

namespace Tests\Feature;

use App\Edition;
use App\Slug as Question;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PostAnswerVoteTest extends TestCase
{
    use DatabaseMigrations;

    function test_post_answer_vote()
    {
        $answer = factory(Edition::class)->states('answer')->create()->translation->translatable;

        $response = $this
            ->actingAs(factory(User::class)->create(), 'api')
            ->json('POST', '/api/answers/' . $answer->id . '/votes');

        $response
            ->assertStatus(200)
            ->assertJson([
                'votesCount' => 1,
                'hasVoteFromCurrentUser' => true,
            ]);
    }
}
