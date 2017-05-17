<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Question;
use App\Edition;
use App\Language;
use App\Translation;

class QuestionPageTest extends TestCase
{
    use DatabaseMigrations;

    function test_get_question_page()
    {
        $question    = factory(Question::class)->create();
        $language    = factory(Language::class)->create();
        $translation = factory(Translation::class)->make();
        $translation->translatable()->associate($question);
        $translation->language()->associate($language);
        $translation->save();
        $edition     = factory(Edition::class)->make();
        $edition->translation()->associate($translation);
        $edition->save();
        $slug        = $question->slugs()->inLanguage($language)->first();
        $question    = $slug;

        $response = $this->get($question->slug);

        $response
            ->assertStatus(200)
            ->assertViewHas(['question']);
    }
}
