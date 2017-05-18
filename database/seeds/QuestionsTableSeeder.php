<?php

use App\Answer;
use App\Edition;
use App\Question;
use App\Slug;
use App\Tag;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    function run()
    {
        Question::all()->each->forceDelete();

        factory(Edition::class)->states('detail')->create();
        factory(Edition::class, 3)->states('answer')->create();
        factory(Edition::class, 3)->states('tag')->create();

        $slug = Slug::first();
        $slug->text = 'slug';
        $slug->save();

        $question = $slug->question;

        $question->tags()->sync(Tag::all());

        foreach (Answer::all() as $answer) {
            $answer->question()->associate($question);
            $answer->save();
        }
    }
}
