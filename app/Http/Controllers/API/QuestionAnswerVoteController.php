<?php

namespace App\Http\Controllers\API;

use App\Answer;
use App\Slug;
use App\Vote;
use App\Notifications\AnswerVoteCreated;

class QuestionAnswerVoteController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function store(Slug $slug, Answer $answer)
    {
        $this->authorize('create', [Vote::class, $answer]);

        $vote = new Vote;
        $vote->votable()->associate($answer);
        $vote->user()->associate(auth()->user());
        $vote->save();

        if (auth()->user()->id != $answer->user->id) {
            $answer->user->notify(new AnswerVoteCreated($vote, $slug));
        }

        return $vote;
    }
}
