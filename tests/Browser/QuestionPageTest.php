<?php

namespace Tests\Browser;

use App\Edition;
use App\Slug as Question;
use App\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class QuestionPageTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_visit_question_page()
    {
        factory(Edition::class)->states('question')->create();
        $question = Question::first();
        factory(Edition::class, 3)->states('tag')->create();
        $question->tags()->sync(Tag::all());

        $this->browse(function (Browser $browser) use ($question) {
            $browser
                ->visit($question->slug)
                ->assertPathIs('/' . $question->slug)
                ->assertTitleContains($question->body)
                ->assertSee($question->body);

            foreach ($question->tags as $tag) {
                $browser->assertSee($tag['body']);
            }
        });
    }

    function test_visit_question_page_with_detail()
    {
        factory(Edition::class)->states('detail')->create();
        $question = Question::first();

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
