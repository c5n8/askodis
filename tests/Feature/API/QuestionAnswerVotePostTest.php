<?php

namespace Tests\Feature\API;

use App\Answer;
use App\Edition;
use App\User;
use App\Vote;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class QuestionAnswerVotePostTest extends TestCase
{
    use DatabaseMigrations;

    function test_question_answer_vote_post()
    {
        $answer = factory(Answer::class)->create();
        $edition = factory(Edition::class)->make();
        $edition->editable()->associate($answer->question);
        $edition->save();
        $slug = $answer->question->slugs()->inLanguage($edition->language)->first();

        $response = $this
            ->actingAs(factory(User::class)->create(), 'api')
            ->json('POST', '/api/questions/' . $slug->id .'/answers/' . $answer->id . '/votes');

        $response
            ->assertStatus(200)
            ->assertJson(Vote::first()->toArray());
    }
}
