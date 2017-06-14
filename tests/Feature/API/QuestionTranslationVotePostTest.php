<?php

namespace Tests\Feature\API;

use App\User;
use App\Slug;
use App\Language;
use App\TranslationRequest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuestionTranslationVotePostTest extends TestCase
{
    use DatabaseMigrations;

    function test_question_translation_vote_post()
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
