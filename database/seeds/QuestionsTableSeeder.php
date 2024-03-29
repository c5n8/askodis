<?php

use App\Answer;
use App\Edition;
use App\Language;
use App\Question;
use App\Slug;
use App\Tag;
use App\User;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    function run()
    {
        Question::all()->each->forceDelete();

        Language::all()->each(function ($language) {
            /*
            |--------------------------------------------------------------------------
            | Mock Question
            |--------------------------------------------------------------------------        |
            */
            $question = factory(Question::class)->create();

            $edition = factory(Edition::class)->make([
                'text' => 'Is this an example of question?' . $language->code
            ]);
            $edition->editable()->associate($question);
            $edition->language()->associate($language);
            $edition->save();

            /*
            |--------------------------------------------------------------------------
            | Mock Detail
            |--------------------------------------------------------------------------        |
            */
            $detail = $question->detail()->save($question->detail()->make());

            $edition = factory(Edition::class)->make(['text' => 'Here is the detail of the question']);
            $edition->editable()->associate($detail);
            $edition->language()->associate($language);
            $edition->save();

            /*
            |--------------------------------------------------------------------------
            | Mock Tag
            |--------------------------------------------------------------------------        |
            */
            $tags = factory(Tag::class, 3)->create()->each(function ($tag) use ($language) {
                $edition = factory(Edition::class)->make(['text' => 'tag' . $tag->id]);
                $edition->editable()->associate($tag);
                $edition->language()->associate($language);
                $edition->save();
            });

            $question->tags()->sync($tags);

            /*
            |--------------------------------------------------------------------------
            | Mock Answer
            |--------------------------------------------------------------------------        |
            */
            $user = factory(User::class)->create(['name' => 'John Doe']);

            $answer = $question->answers()->make();
            $answer->question()->associate($question);
            $answer->user()->associate($user);
            $answer->save();

            $edition = factory(Edition::class)->make(['text' => 'Here is my answer']);
            $edition->editable()->associate($answer);
            $edition->language()->associate($language);
            $edition->user()->associate($user);
            $edition->save();
        });
    }
}
