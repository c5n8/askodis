<?php

use App\Edition;
use App\Slug as Question;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    function run()
    {
        Question::all()->each->forceDelete();

        factory(Edition::class)->states('answer')->create();
        dump(Question::first()->slug);
    }
}
