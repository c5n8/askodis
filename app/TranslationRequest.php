<?php

namespace App;

use App\Traits\FromUser;

class TranslationRequest extends Model
{
    use FromUser;

    function translatable()
    {
        return $this->morphTo();
    }

    function originLanguage()
    {
        return $this->belongsTo(Language::class, 'origin_language_id');
    }

    function targetLanguage()
    {
        return $this->belongsTo(Language::class, 'target_language_id');
    }

    function scopeFromLanguage($query, $language)
    {
        return $query->where('origin_language_id', $language->id);
    }

    function scopeToLanguage($query, $language)
    {
        return $query->where('target_language_id', $language->id);
    }
}
