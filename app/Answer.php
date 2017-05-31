<?php

namespace App;

use App\Question;
use App\Traits\Editable;
use App\Traits\FromUser;
use App\Traits\Votable;

class Answer extends Model
{
    use Editable, FromUser, Votable;

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
