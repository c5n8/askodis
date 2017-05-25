<?php

namespace Tests\Feature\API\Question\Answer;

use App\Edition;
use App\Slug as Question;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PatchAnswerTest extends TestCase
{
    use DatabaseMigrations;

    function test_patch_answer()
    {
        factory(Edition::class)->states('answer')->create();
        $user = User::first();
        $question = Question::first();

        $input = factory(Edition::class)->states('answer')->make();

        $response = $this
            ->actingAs($user, 'api')
            ->json('PATCH', '/api/questions/' . $question->id . '/answers', [
                'body' => $input->text,
            ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'body' => $input->text,
            ]);
    }
}
