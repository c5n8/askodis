<?php

namespace Tests\Feature;

use App\Edition;
use App\Slug as Question;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class QuestionPageTest extends TestCase
{
    use DatabaseMigrations;

    fTranslatableunction test_get_question_page()
    {
        factory(Edition::class)->states('question')->create();
        $question = Question::first();

        $response = $this->get($question->slug);

        $response
            ->assertStatus(200)
            ->assertViewHas(['question']);
    }
}
