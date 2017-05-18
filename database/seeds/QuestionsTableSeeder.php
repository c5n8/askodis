<?php

use App\Edition;
use App\Slug as Question;
use App\Tag;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    function run()
    {
        Question::all()->each->forceDelete();
        factory(Edition::class)->states('answer')->create();
        $question = Question::first();
        factory(Edition::class, 3)->states('tag')->create();
        $question->tags()->sync(Tag::all());
        dump($question->slug);
    }
}
