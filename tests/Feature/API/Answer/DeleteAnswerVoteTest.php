<?php

namespace Tests\Feature\API\Answer;

use App\Edition;
use App\Slug as Question;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteAnswerVoteTest extends TestCase
{
    use DatabaseMigrations;

    function test_delete_answer_vote()
    {
        $answer = factory(Edition::class)->states('answer')->create()->translation->translatable;

        $response = $this
            ->actingAs(factory(User::class)->create(), 'api')
            ->json('DELETE', '/api/answers/' . $answer->id . '/votes');

        $response
            ->assertStatus(200)
            ->assertJson([
                'votesCount' => 0,
                'hasVoteFromCurrentUser' => false,
            ]);
    }
}
