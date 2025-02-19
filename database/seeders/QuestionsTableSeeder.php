<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Edition;
use App\Models\Language;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    public function run()
    {
        Question::all()->each->forceDelete();

        Language::all()->each(function ($language) {
            /*
            |--------------------------------------------------------------------------
            | Mock Question
            |--------------------------------------------------------------------------        |
            */
            $question = Question::create();

            $edition = Edition::factory()->make([
                'text' => 'Is this an example of question?'.$language->code,
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

            $edition = Edition::factory()->make(['text' => 'Here is the detail of the question']);
            $edition->editable()->associate($detail);
            $edition->language()->associate($language);
            $edition->save();

            /*
            |--------------------------------------------------------------------------
            | Mock Tag
            |--------------------------------------------------------------------------        |
            */
            $tags = Tag::factory()->count(3)->create()->each(function ($tag) use ($language) {
                $edition = Edition::factory()->make(['text' => 'tag'.$tag->id]);
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
            $user = User::factory()->create(['name' => 'John Doe']);

            $answer = $question->answers()->make();
            $answer->question()->associate($question);
            $answer->user()->associate($user);
            $answer->save();

            $edition = Edition::factory()->make(['text' => 'Here is my answer']);
            $edition->editable()->associate($answer);
            $edition->language()->associate($language);
            $edition->user()->associate($user);
            $edition->save();
        });
    }
}
