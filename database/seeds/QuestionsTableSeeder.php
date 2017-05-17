<?php

use App\Detail;
use App\Edition;
use App\Language;
use App\Question;
use App\Translation;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    function run()
    {
        Question::all()->each->forceDelete();

        $question    = factory(Question::class)->create();
        $language    = factory(Language::class)->create();
        $translation = factory(Translation::class)->make();
        $translation->translatable()->associate($question);
        $translation->language()->associate($language);
        $translation->save();
        $edition     = factory(Edition::class)->make([
            'text' => 'Is this the question body?',
        ]);
        $edition->translation()->associate($translation);
        $edition->save();

        $detail      = factory(Detail::class)->make();
        $detail->question()->associate($question);
        $detail->save();
        $translation = factory(Translation::class)->make();
        $translation->translatable()->associate($detail);
        $translation->language()->associate($language);
        $translation->save();
        $edition     = factory(Edition::class)->make();
        $edition->translation()->associate($translation);
        $edition->save();
    }
}
