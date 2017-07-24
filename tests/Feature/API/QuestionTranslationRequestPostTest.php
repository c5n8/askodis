<?php

namespace Tests\Feature\API;

use App\Slug;
use App\User;
use App\Vote;
use App\Language;
use App\TranslationRequest;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class QuestionTranslationRequestPostTest extends TestCase
{
    use DatabaseMigrations;

    function test_question_translation_request_post()
    {
        $slug = factory(Slug::class)->create();

        $language = factory(Language::class)->create();

        $response = $this
            ->actingAs(factory(User::class)->create(), 'api')
            ->json('POST', '/api/questions/' . $slug->id . '/translation_requests', [
                'language' => $language->code,
            ]);

        $response
            ->assertStatus(200)
            ->assertJson(TranslationRequest::first()->toArray());
    }
}
