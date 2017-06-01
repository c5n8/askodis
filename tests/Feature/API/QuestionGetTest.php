<?php

namespace Tests\Feature\API;

use App\Slug;
use App\Edition;
use App\Question;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class QuestionGetTest extends TestCase
{
    use DatabaseMigrations;

    function test_question_get()
    {
        factory(Question::class)->create()
            ->editions()->save(factory(Edition::class)->make());

        $slug = Slug::first();

        $response = $this->json('GET', '/api/questions/' . $slug->id);

        $response
            ->assertStatus(200)
            ->assertJson($slug->toArray());
    }
}
