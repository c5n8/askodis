<?php

namespace Tests\Feature\API;

use App\Language;
use App\Question;
use App\User;
use App\Answer;
use App\Edition;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuestionsGetTest extends TestCase
{
    use DatabaseMigrations;

    function test_questions_get()
    {
        $languages = factory(Language::class, 2)->create()->each(function ($language) {
            $question = factory(Question::class)->create();

            $edition = factory(Edition::class)->make();
            $edition->editable()->associate($question);
            $edition->language()->associate($language);
            $edition->save();

            $answer = factory(Answer::class)->create();
            $answer->question()->associate($question);
            $answer->save();

            $edition = factory(Edition::class)->make();
            $edition->editable()->associate($answer);
            $edition->language()->associate($language);
            $edition->user()->associate($answer->user);
            $edition->save();
        });

        $user      = factory(User::class)->create();
        $user->languages()->sync($languages);

        $response = $this
            ->actingAs($user, 'api')
            ->json('GET', '/api/questions');

        $response
            ->assertStatus(200);
    }
}
