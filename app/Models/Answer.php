<?php

namespace App\Models;

use App\Traits\Editable;
use App\Traits\FromUser;
use App\Traits\TranslationRequestable;
use App\Traits\Votable;

class Answer extends Model
{
    use Editable, FromUser, TranslationRequestable, Votable;

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

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
