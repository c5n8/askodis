<?php

namespace App;

use App\Language;
use App\Question;
use App\Traits\ActAsQuestion;

class Slug extends Model
{
    use ActAsQuestion;

    protected $visible = [
        'id',
        'answerRequestsCount',
        'hasAnswerRequestFromCurrentUser',
        'hasAnswerFromCurrentUser',
        'answerFromCurrentUser',
        'answersCount',
        'answers',
    ];

    protected $appends = [
        'answerRequestsCount',
        'hasAnswerRequestFromCurrentUser',
        'hasAnswerFromCurrentUser',
        'answerFromCurrentUser',
        'answersCount',
        'answers',
    ];

    function question()
    {
        return $this->belongsTo(Question::class);
    }

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
