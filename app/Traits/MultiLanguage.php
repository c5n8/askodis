<?php

namespace App\Traits;

use App\Models\Language;

trait MultiLanguage
{
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function scopeInLanguage($query, $language)
    {
        return $query->whereHas('language', function ($query) use ($language) {
            $query->where('id', $language->id);
        });
    }
}
