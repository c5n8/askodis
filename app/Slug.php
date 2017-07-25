<?php

namespace App;

use App\Question;
use App\Traits\ActAsQuestion;
use App\Traits\MultiLanguage;
use Laravel\Scout\Searchable;

class Slug extends Model
{
    use ActAsQuestion, MultiLanguage, Searchable;

    protected $visible = [
        'id',
        'votesCount',
        'hasDetail',
        'hasVoteFromCurrentUser',
        'hasAnswerFromCurrentUser',
        'answerFromCurrentUser',
        'voteFromCurrentUser',
        'answersCount',
        'answers',
        'slug',
        'body',
        'detail',
        'tags',
        'shareUrl',
        'language',
        'relatedQuestions',
    ];

    protected $appends = [
        'votesCount',
        'hasDetail',
        'hasVoteFromCurrentUser',
        'hasAnswerFromCurrentUser',
        'answerFromCurrentUser',
        'voteFromCurrentUser',
        'answersCount',
        'answers',
        'slug',
        'body',
        'detail',
        'tags',
        'shareUrl',
        'relatedQuestions',
    ];

    function question()
    {
        return $this->belongsTo(Question::class);
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
