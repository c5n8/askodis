<?php

namespace Tests\Feature\API;

use App\Slug;
use App\User;
use App\Vote;
use App\Answer;
use App\Language;
use App\TranslationRequest;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AnswerTranslationRequestPostTest extends TestCase
{
    use DatabaseMigrations;

    function test_answer_translation_request_post()
    {
        $slug = factory(Slug::class)->create();
        $answer = $slug->question->answers()->save(factory(Answer::class)->make());

        $language = factory(Language::class)->create();

        $response = $this
            ->actingAs(factory(User::class)->create(), 'api')
            ->json('POST', '/api/answers/' . $answer->id . '/translation_requests', [
                'language' => $language->code,
            ]);

        $response
            ->assertStatus(200)
            ->assertJson(TranslationRequest::first()->toArray());
    }
}
