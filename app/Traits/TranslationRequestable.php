<?php

namespace App\Traits;

use App\TranslationRequest;

trait TranslationRequestable
{
    public function translationRequests()
    {
        return $this->morphMany(TranslationRequest::class, 'requestable');
    }

    public function getTranslationRequestsCountAttribute()
    {
        return $this->translationRequests()->count();
    }

    public function getHasTranslationRequestFromCurrentUserAttribute()
    {
        if (auth('api')->guest()) {
            return false;
        }

        return $this->translationRequests()->from(auth('api')->user())->exists();
    }

    public function getTranslationRequestFromCurrentUserAttribute()
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
