<?php

namespace Tests\Feature;

use App\Edition;
use App\Slug as Question;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PostAnswerTest extends TestCase
{
    use DatabaseMigrations;

    function test_post_answer()
    {
        factory(Edition::class)->states('question')->create();
        $question = Question::first();

        $response = $this
            ->actingAs(factory(User::class)->create(), 'api')
            ->json('POST', '/api/questions/' . $question->id . '/answers', [
                'body' => factory(Edition::class)->states('answer')->make()->text,
            ]);

        $response
            ->assertStatus(200)
            ->assertJson($question->answerFromCurrentUser->toArray());
    }
}
