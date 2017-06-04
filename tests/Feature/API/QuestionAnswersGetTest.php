<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Slug;
use App\Answer;
use App\Edition;

class QuestionAnswersGetTest extends TestCase
{
    use DatabaseMigrations;

    function test_question_answers_get()
    {
        $slug = factory(Slug::class)->create();
        $question = $slug->question;
        $language = $slug->language;

        factory(Answer::class, 11)->make()->each(function ($answer) use ($question, $language) {
            $answer->question()->associate($question);
            $answer->save();

            $edition = factory(Edition::class)->make();
            $edition->editable()->associate($answer);
            $edition->language()->associate($language);
            $edition->user()->associate($answer->user);
            $edition->save();
        });

        $response = $this
            ->json('GET', '/api/questions/' . $slug->id . '/answers');

        $response
            ->assertStatus(200)
            ->assertJson($slug->answers->toArray());
    }
}
