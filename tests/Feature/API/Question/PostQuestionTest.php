<?php

namespace Tests\Feature\API;

use App\Edition;
use App\Language;
use App\Slug as Question;
use App\Tag;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PostQuestionTest extends TestCase
{
    use DatabaseMigrations;

    function test_post_question()
    {
        $user     = factory(User::class)->create();
        $language = factory(Language::class)->create();
        $user->languages()->attach($language, ['is_preferred' => true]);

        $tag = factory(Tag::class)->create();

        $translation = $tag->translations()->make();
        $translation->translatable()->associate($tag);
        $translation->language()->associate($language);
        $translation->save();

        $edition = factory(Edition::class)->make(['text' => 'tag 1']);
        $edition->translation()->associate($translation);
        $edition->save();

        $response = $this
            ->actingAs($user, 'api')
            ->json('POST', '/api/questions', [
                'body'     => factory(Edition::class)->make()->text,
                'detail'   => factory(Edition::class)->make()->text,
                'tags'     => [
                    'tag 1',
                    'tag 2',
                    'tag 3',
                ],
                'language' => $language->code,
            ]);

        $question = Question::first();

        $response
            ->assertStatus(200)
            ->assertJson($question->toArray());
    }
}
