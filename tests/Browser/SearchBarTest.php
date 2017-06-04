<?php

namespace Tests\Browser;

use App\Edition;
use App\Slug;
use App\Question;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class SearchBarTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_search_bar()
    {
        config(['scout.driver' => 'algolia']);

        factory(Question::class)
            ->create()
            ->editions()
            ->save(factory(Edition::class)->make());

        $question = Slug::first();

        $this->browse(function (Browser $browser) use ($question) {
            $browser
                ->visit('/')
                ->type('search', $question->body)
                ->whenAvailable('.results', function ($results) use ($question) {
                    $results
                    ->assertSee($question->body)
                        ->clickLink($question->body)
                        ->assertPathIs('/'.$question->slug);
                });
        });
    }
}
