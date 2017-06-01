<?php

namespace App\Traits;

use App\Language;


trait MultiLanguage
{
    function language()
    {
        return $this->belongsTo(Language::class);
    }

    function scopeInLanguage($query, $language)
    {
        return $query->whereHas('language', function ($query) use ($language) {
            $query->where('id', $language->id);
        });
    }
}
