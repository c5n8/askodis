<?php

namespace App;

use App\AnswerRequest;
use App\Detail;
use App\Slug;
use App\Translation;

class Question extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($question) {
            if ($question->isforceDeleting()) {
                $question->translations()->forceDelete();

                return;
            }

            $question->translations()->delete();
        });
    }

    function slugs()
    {
        return $this->hasMany(Slug::class);
    }

    function detail()
    {
        return $this->hasOne(Detail::class);
    }

    function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    function answerRequests()
    {
        return $this->hasMany(AnswerRequest::class);
    }
}
