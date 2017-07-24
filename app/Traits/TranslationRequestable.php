<?php

namespace App\Traits;

use App\TranslationRequest;

trait TranslationRequestable
{
    function translationRequests()
    {
        return $this->morphMany(TranslationRequest::class, 'requestable');
    }

    function getTranslationRequestsCountAttribute()
    {
        return $this->translationRequests()->count();
    }

    function getHasTranslationRequestFromCurrentUserAttribute()
    {
        if (auth('api')->guest()) {
            return false;
        }

        return $this->translationRequests()->from(auth('api')->user())->exists();
    }

    function getTranslationRequestFromCurrentUserAttribute()
    {
        if (auth('api')->guest()) {
            return;
        }

        if (! $this->hasTranslationRequestFromCurrentUser) {
            return;
        }

        return $this->translationRequests()->from(auth('api')->user())->first();
    }
}
