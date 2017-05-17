<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Detail;
use App\Question;
use App\Edition;
use App\Language;
use App\Translation;

class QuestionPageTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_visit_question_page()
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

        $this->browse(function (Browser $browser) use ($question) {
            $browser
                ->visit($question->slug)
                ->assertPathIs('/' . $question->slug)
                ->assertTitleContains($question->body)
                ->assertSee($question->body);
        });
    }

    function test_visit_question_page_with_detail()
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

        $detail      = factory(Detail::class)->make();
        $detail->question()->associate($question);
        $detail->save();
        $translation = factory(Translation::class)->make();
        $translation->translatable()->associate($detail);
        $translation->language()->associate($language);
        $translation->save();
        $edition     = factory(Edition::class)->make();
        $edition->translation()->associate($translation);
        $edition->save();

        $slug        = $question->slugs()->inLanguage($language)->first();
        $question    = $slug;

        $this->browse(function (Browser $browser) use ($question) {
            $browser
                ->visit($question->slug)
                ->assertPathIs('/' . $question->slug)
                ->assertTitleContains($question->body)
                ->assertSee($question->body)
                ->assertSee($question->detail);
        });
    }
}
