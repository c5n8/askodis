<?php

namespace Tests\Feature\API;

use App\Edition;
use App\Language;
use App\Slug;
use App\Tag;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class QuestionPostTest extends TestCase
{
    use DatabaseMigrations;

    function test_question_post()
    {
        $language = factory(Language::class)->create();
        $user     = factory(User::class)->create();

        $tag = factory(Tag::class)->create();

        $edition = factory(Edition::class)->make(['text' => 'tag 1']);
        $edition->editable()->associate($tag);
        $edition->language()->associate($language);
        $edition->save();

        $response = $this
            ->actingAs($user, 'api')
            ->json('POST', '/api/questions', [
                'body'     => 'Question body',
                'detail'   => 'Question detail',
                'tags'     => [
                    'tag 1',
                    'tag 2',
                    'tag 3',
                ],
                'language' => $language->code,
            ]);

        $response
            ->assertStatus(200)
            ->assertJson(Slug::first()->toArray());
    }
}
