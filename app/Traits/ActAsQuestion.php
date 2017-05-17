<?php

namespace App\Traits;

trait ActAsQuestion
{
    function getSlugAttribute()
    {
        return $this->text;
    }

    function getBodyAttribute()
    {
        return $this
            ->question
            ->translations()
            ->inLanguage($this->language)
            ->first()
            ->editions()
            ->latest()
            ->first()
            ->text;
    }

    function getHasDetailAttribute()
    {
        return $this->question->detail()->exists();
    }

    function getDetailAttribute()
    {
        return $this
            ->question
            ->detail
            ->translations()
            ->inLanguage($this->language)
            ->first()
            ->editions()
            ->latest()
            ->first()
            ->text;
    }
}
