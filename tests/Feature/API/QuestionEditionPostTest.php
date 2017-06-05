<?php

namespace Tests\Feature\API;

use App\Edition;
use App\User;
use App\Slug;
use App\Language;
use App\Question;
use App\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class QuestionEditionPostTest extends TestCase
{
    use DatabaseMigrations;

    function test_question_edition_post()
    {
        $language = factory(Language::class)->create();
        $slug = factory(Slug::class)->create();

        $tags = factory(Tag::class, 3)->create()->each(function ($tag) use ($language) {
            $edition = factory(Edition::class)->make(['text' => 'tag' . $tag->id]);
            $edition->editable()->associate($tag);
            $edition->language()->associate($language);
            $edition->save();
        });

        $slug->question->tags()->sync($tags);

        $tags = $tags->transform(function ($tag) {
            return [
                'id' => $tag->id,
                'body' => 'newTag' . $tag->id,
            ];
        });

        $response = $this
            ->actingAs(factory(User::class)->create(), 'api')
            ->json('POST', '/api/questions/' . $slug->id . '/editions', [
                'body'     => 'Translated question',
                'detail'   => 'Translated detail',
                'tags'     => $tags,
                'language' => factory(Language::class)->create()->code,
            ]);

        $slug = Slug::where('text', 'translated-question')->first();

        $response
            ->assertStatus(200)
            ->assertJson($slug->toArray());
    }
}
