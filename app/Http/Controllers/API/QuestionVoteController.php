<?php

namespace App\Http\Controllers\API;

use App\Slug;
use App\Vote;

class QuestionVoteController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function store(Slug $slug)
    {
        $question = $slug->question;

        $this->authorize('create', [Vote::class, $question]);

        $vote = new Vote;
        $vote->votable()->associate($question);
        $vote->user()->associate(auth()->user());
        $vote->save();

        return $vote;
    }
}
