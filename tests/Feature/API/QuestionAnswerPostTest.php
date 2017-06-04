<?php

namespace Tests\Feature\API;

use App\Answer;
use App\Edition;
use App\Slug;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class QuestionAnswerPostTest extends TestCase
{
    use DatabaseMigrations;

    function test_question_answer_post()
    {
        $slug = factory(Slug::class)->create();

        $response = $this
            ->actingAs(factory(User::class)->create(), 'api')
            ->json('POST', '/api/questions/' . $slug->id . '/answers', [
                'body' => 'Answer body',
            ]);

        $answer = Answer::first();
        $edition = $answer->editions()->latest()->first();

        $response
            ->assertStatus(200)
            ->assertJson([
                'id'                     => $answer->id,
                'body'                   => $edition->text,
                'updatedAt'              => $answer->updated_at->toDateTimeString(),
                'votesCount'             => $answer->votesCount,
                'hasVoteFromCurrentUser' => $answer->hasVoteFromCurrentUser,
                'user'                   => $answer->user->ToArray(),
            ]);
    }
}
