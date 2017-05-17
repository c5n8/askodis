<?php

namespace Tests\Feature;

use App\Edition;
use App\Slug as Question;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GetQuestionTest extends TestCase
{
    use DatabaseMigrations;

    function test_get_question()
    {
        factory(Edition::class)->states('question')->create();
        $question = Question::first();

        $response = $this->json('GET', '/api/questions/' . $question->id);

        $response
            ->assertStatus(200)
            ->assertJson($question->toArray());
    }
}
