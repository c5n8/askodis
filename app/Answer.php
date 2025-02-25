<?php

namespace App;

use App\Question;
use App\Traits\Editable;
use App\Traits\FromUser;
use App\Traits\Votable;
use App\Traits\TranslationRequestable;

class Answer extends Model
{
    use Editable, FromUser, Votable, TranslationRequestable;

    protected $visible = [
        'id',
        'votesCount',
        'hasVoteFromCurrentUser',
        'voteFromCurrentUser',
    ];

    protected $appends = [
        'votesCount',
        'hasVoteFromCurrentUser',
        'voteFromCurrentUser',
    ];

    function question()
    {
        return $this->belongsTo(Question::class);
    }
}
