<?php

namespace Tests\Browser;

use App\Edition;
use App\Slug as Question;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class SearchBarTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_search_bar()
    {
        config(['scout.driver' => 'algolia']);

        factory(Edition::class)->states('question')->create();
        $question = Question::first();

        $this->browse(function (Browser $browser) use ($question) {
            $browser->visit('/')
                ->type('search', $question->body)
                ->whenAvailable('.results', function ($results) use ($question) {
                    $results->assertSee($question->body)
                        ->clickLink($question->body)
                        ->assertPathIs('/'.$question->slug);
                });
        });
    }
}
