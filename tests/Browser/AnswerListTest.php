<?php

namespace Tests\Browser;

use App\Edition;
use App\Slug as Question;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AnswerListTest extends DuskTestCase
{
    use DatabaseMigrations;

    function test_answer_list()
    {
        factory(Edition::class)->states('answer')->create();
        $question = Question::first();

        $this->browse(function (Browser $browser) use ($question) {
            $browser
                ->visit($question->slug)
                ->assertPathIs('/' . $question->slug);

            foreach ($question->answers as $answer) {
                $browser
                    ->assertSee('1 Answers')
                    ->assertSee($answer['user']['name'])
                    ->assertSee($answer['body']);
            }
        });
    }
}
