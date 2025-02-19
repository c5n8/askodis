<?php

namespace App\Models;

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

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function searchableAs()
    {
        return 'questions';
    }

    public function toSearchableArray()
    {
        return [
            'slug' => $this->text,
            'body' => $this->body,
            'language' => $this->language->code,
        ];
    }
}
