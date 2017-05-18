<?php

namespace App\Traits;

use App\Translation;

trait Translatable
{
    function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    function translationInLanguage($language)
    {
        return $this->translations()->inLanguage($language)->first();
    }

    function scopeHasTranslationInLanguage($query, $language)
    {
        return $query->whereHas('translations', function ($query) use ($language) {
            $query->inLanguage($language);
        });
    }
}
