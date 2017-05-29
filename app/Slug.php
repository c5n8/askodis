<?php

namespace App;

use App\Language;
use App\Question;
use App\Traits\ActAsQuestion;
use Laravel\Scout\Searchable;

class Slug extends Model
{
    use ActAsQuestion, Searchable;

    protected $visible = [
        'id',
        'answerRequestsCount',
        'hasAnswerRequestFromCurrentUser',
        'hasAnswerFromCurrentUser',
        'answerFromCurrentUser',
        'answersCount',
        'answers',
        'slug',
    ];

    protected $appends = [
        'answerRequestsCount',
        'hasAnswerRequestFromCurrentUser',
        'hasAnswerFromCurrentUser',
        'answerFromCurrentUser',
        'answersCount',
        'answers',
        'slug',
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

    function searchableAs()
    {
        return 'questions';
    }

    function toSearchableArray()
    {
        return [
            'slug'     => $this->text,
            'body'     => $this->body,
            'language' => $this->language->code,
        ];
    }
}
