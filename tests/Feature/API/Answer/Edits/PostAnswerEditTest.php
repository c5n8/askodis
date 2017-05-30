<?php

namespace Tests\Feature\API\Answer\Edits;

use App\Edition;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostAnswerEditTest extends TestCase
{
    use DatabaseMigrations;

    function test_post_answer_edit()
    {
        $answer = factory(Edition::class)->states('answer')->create()->translation->translatable;

        $response = $this
            ->actingAs(factory(User::class)->create(), 'api')
            ->json(
                'POST',
                '/api/questions/' . $answer->question->id. '/answers/' . $answer->id . '/edits',
                [
                    'body' => 'Answer edit',
                ]
            );

        $response
            ->assertStatus(201)
            // ->assertJson([
            //     'votesCount' => 1,
            //     'hasVoteFromCurrentUser' => true,
            // ])
            ;
    }
}
