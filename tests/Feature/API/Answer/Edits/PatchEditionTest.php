<?php

namespace Tests\Feature\API\Answer\Edits;

use App\Language;
use App\Edition;
use App\Question;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PatchEditionTest extends TestCase
{
    use DatabaseMigrations;

    function test_patch_edition()
    {
        $language = factory(Language::class)->create();

        /*
        |--------------------------------------------------------------------------
        | Mock Question
        |--------------------------------------------------------------------------        |
        */
        $question = factory(Question::class)->create();

        $translation = $question->translations()->make();
        $translation->translatable()->associate($question);
        $translation->language()->associate($language);
        $translation->save();

        $edition = factory(Edition::class)->make(['text' => 'Is this an example of question?']);
        $edition->translation()->associate($translation);
        $edition->save();

        /*
        |--------------------------------------------------------------------------
        | Mock Answer
        |--------------------------------------------------------------------------        |
        */
        $user = factory(User::class)->create();

        $answer = $question->answers()->make();
        $answer->question()->associate($question);
        $answer->user()->associate($user);
        $answer->save();

        $translation = $answer->translations()->make();
        $translation->translatable()->associate($answer);
        $translation->language()->associate($language);
        $translation->save();

        $edition = factory(Edition::class)->make();
        $edition->user()->associate($user);
        $edition->translation()->associate($translation);
        $edition->save();

        /*
        |--------------------------------------------------------------------------
        | Mock Edit Suggestion
        |--------------------------------------------------------------------------        |
        */
        $edition = factory(Edition::class)->make();
        $edition->status = 'pending';
        $edition->translation()->associate($translation);
        $edition->save();

        $response = $this
            ->actingAs($answer->user, 'api')
            ->json(
                'PATCH',
                '/api/edits/' . $edition->id,
                [
                    'status' => 'accepted',
                ]
            );

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'accepted',
            ]);
    }
}
