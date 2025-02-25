<?php

namespace Tests\Browser;

use App\Edition;
use App\Slug;
use App\Question;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class SearchBarTest extends DuskTestCase
{
    use DatabaseTruncation;

    function test_search_bar()
    {
        config(['scout.driver' => 'algolia']);

        Question::factory()
            ->create()
            ->editions()
            ->save(Edition::factory()->make());

        $question = Slug::first();

        $this->browse(function (Browser $browser) use ($question) {
            $browser
                ->visit('/')
                ->whenAvailable('.ui.search', function (Browser $browser) use ($question) {
                    $browser
                        ->type('search', $question->body)
                        ->whenAvailable('.results', function ($results) use ($question) {
                            $results
                                ->assertSee($question->body)
                                ->clickLink($question->body)
                                ->assertPathIs('/'.$question->slug);
                        });
                });
        });
    }
}
