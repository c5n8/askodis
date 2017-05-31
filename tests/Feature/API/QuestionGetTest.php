<?php

namespace Tests\Feature\API;

use App\Slug;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class QuestionGetTest extends TestCase
{
    use DatabaseMigrations;

    function test_question_get()
    {
        $slug = factory(Slug::class)->create();

        $response = $this->json('GET', '/api/questions/' . $slug->id);

        $response
            ->assertStatus(200)
            ->assertJson($slug->toArray());
    }
}
