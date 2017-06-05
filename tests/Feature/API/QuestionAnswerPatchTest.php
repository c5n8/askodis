<?php

namespace Tests\Feature\API;

use App\Answer;
use App\Edition;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuestionAnswerPatchTest extends TestCase
{
    use DatabaseMigrations;

    private $slug;
    private $answer;

    protected function setUp()
    {
        parent::setUp();

        $this->answer = factory(Answer::class)->create();

        $edition = factory(Edition::class)->make();
        $edition->editable()->associate($this->answer->question);
        $edition->save();

        $this->slug = $this->answer->question->slugs()->inLanguage($edition->language)->first();
    }

    function test_question_answer_patch_by_original_user()
    {
        $response = $this
            ->actingAs($this->answer->user, 'api')
            ->json(
                'PATCH',
                '/api/questions/' . $this->slug->id. '/answers/' . $this->answer->id,
                [
                    'body' => 'Answer edit',
                ]
            );

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

    function test_question_answer_patch_by_other_user()
    {
        $response = $this
            ->actingAs(factory(User::class)->create(), 'api')
            ->json(
                'PATCH',
                '/api/questions/' . $this->slug->id. '/answers/' . $this->answer->id,
                [
                    'body' => 'Answer edit',
                ]
            );

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
