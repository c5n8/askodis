<?php

namespace Tests\Feature\API;

use App\Answer;
use App\Edition;
use App\User;
use App\Slug;
use App\Language;
use App\Question;
use App\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class QuestionAnswerEditionPostTest extends TestCase
{
    use DatabaseMigrations;

    function test_question_answer_edition_post()
    {
        $language = factory(Language::class)->create();
        $slug = factory(Slug::class)->create();
        $answer = $slug->question->answers()->save(factory(Answer::class)->make());

        $response = $this
            ->actingAs(factory(User::class)->create(), 'api')
            ->json('POST', '/api/questions/' . $slug->id . '/answers/' . $answer->id . '/editions', [
                'body'     => 'Translated answer',
                'language' => factory(Language::class)->create()->code,
            ]);

        $edition = Edition::latest()->first();

        $response
            ->assertStatus(200)
            ->assertJson($edition->toArray());
    }
}
