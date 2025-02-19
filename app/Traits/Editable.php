<?php

namespace App\Traits;

use App\Models\Edition;

trait Editable
{
    public function editions()
    {
        return $this->morphMany(Edition::class, 'editable');
    }

    public function scopeHasEditionInLanguage($query, $language)
    {
        return $query->whereHas('editions', function ($query) use ($language) {
            $query->inLanguage($language);
        });
    }
}
