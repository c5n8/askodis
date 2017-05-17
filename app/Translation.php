<?php

namespace App;

use App\Edition;
use App\Language;

class Translation extends Model
{
    function translatable()
    {
        return $this->morphTo();
    }

    function language()
    {
        return $this->belongsTo(Language::class);
    }

    function editions()
    {
        return $this->hasMany(Edition::class);
    }

    function scopeInLanguage($query, $language)
    {
        return $query->whereHas('language', function ($query) use ($language) {
            $query->where('id', $language->id);
        });
    }

    function hasType($type)
    {
        return $this->translatable_type == $type;
    }
}
