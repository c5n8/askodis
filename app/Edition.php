<?php

namespace App;

use App\Slug;
use App\Translation;

class Edition extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::created(function ($edition) {
            if ($edition->translation->hasType('question')) {
                $translation = $edition->translation;
                $question    = $translation->translatable;
                $language    = $translation->language;
                $slug        = $question->slugs()->inLanguage($language)->first();

                if (is_null($slug)) {
                    $slug = new Slug;
                    $slug->question()->associate($question);
                    $slug->language()->associate($language);
                }

                $slug->text = str_slug($edition->text);
                $slug->save();
            }
        });
    }

    function translation()
    {
        return $this->belongsTo(Translation::class);
    }
}
