<?php

namespace Tests\Feature;

use App\Edition;
use App\Slug as Question;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PostAnswerRequestTest extends TestCase
{
    use DatabaseMigrations;

    function test_post_answer_request()
    {
        factory(Edition::class)->states('question')->create();
        $question = Question::first();

        $response = $this
            ->actingAs(factory(User::class)->create(), 'api')
            ->json('POST', '/api/questions/' . $question->id . '/answer_requests');

        $response
            ->assertStatus(200)
            ->assertJson([
                'answerRequestsCount' => 1,
                'hasAnswerRequestFromCurrentUser' => true,
            ]);
    }
}
