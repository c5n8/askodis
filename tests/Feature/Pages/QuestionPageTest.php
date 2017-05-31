<?php

namespace Tests\Feature\Pages;

use App\Edition;
use App\Question;
use App\Slug;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class QuestionPageTest extends TestCase
{
    use DatabaseMigrations;

    function test_get_question_page()
    {
        $question = factory(Question::class)->create();
        $question->editions()->save(factory(Edition::class)->make());

        $response = $this->get(Slug::first()->text);

        $response
            ->assertStatus(200)
            ->assertViewHas(['question']);
    }
}
