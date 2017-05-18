<?php

namespace App;

use App\Answer;
use App\AnswerRequest;
use App\Detail;
use App\Slug;
use App\Tag;
use App\Traits\Translatable;

class Question extends Model
{
    use Translatable;

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

    function answerRequests()
    {
        return $this->hasMany(AnswerRequest::class);
    }

    function answers()
    {
        return $this->hasMany(Answer::class);
    }

    function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    function getHasDetailAttribute()
    {
        return $this->detail()->exists();
    }

    function getAnswerRequestsCountAttribute()
    {
        return $this->answerRequests()->count();
    }

    function getHasAnswerRequestFromCurrentUserAttribute()
    {
        if (auth('api')->guest()) {
            return false;
        }

        return $this->answerRequests()->from(auth('api')->user())->exists();
    }

    function getAnswersCountAttribute()
    {
        return $this->answers()->count();
    }

    function startRequestingAnswer()
    {
        if ($this->hasAnswerRequestFromCurrentUser) {
            return;
        }

        $answerRequest = $this->answerRequests()->make();
        $answerRequest->question()->associate($this);
        $answerRequest->user()->associate(auth()->user());
        $answerRequest->save();
    }

    function stopRequestingAnswer()
    {
        if ($this->hasAnswerRequestFromCurrentUser) {
            $this->answerRequests()->from(auth()->user())->delete();
        }
    }
}
