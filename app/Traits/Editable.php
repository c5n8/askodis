<?php

namespace App\Traits;

use App\Edition;

trait Editable
{
    function editions()
    {
        return $this->morphMany(Edition::class, 'editable');
    }

    function scopeHasEditionInLanguage($query, $language)
    {
        return $query->whereHas('editions', function ($query) use ($language) {
            $query->inLanguage($language);
        });
    }
}
