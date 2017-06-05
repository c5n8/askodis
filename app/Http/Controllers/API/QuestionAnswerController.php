<?php

namespace App\Http\Controllers\API;

use App\Answer;
use App\Slug;
use App\Edition;
use App\Notifications\AnswerCreated;

class QuestionAnswerController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'update']);
    }

    function index(Slug $slug)
    {
        return $slug
            ->question
            ->answers()
            ->withCount('votes')
            ->orderBy('votes_count', 'desc')
            ->hasEditionInLanguage($slug->language)
            ->when(request()->has('loadedAnswers'), function ($query) {
                return $query->whereNotIn('id', request('loadedAnswers'));
            })
            ->limit(5)
            ->get()
            ->transform(function ($answer) use ($slug) {
                return collect([
                    'id'                     => $answer->id,
                    'body'                   => $answer
                                                    ->editions()
                                                    ->inLanguage($slug->language)
                                                    ->accepted()
                                                    ->latest()
                                                    ->first()
                                                    ->text,
                    'updatedAt'              => $answer->updated_at->toDateTimeString(),
                    'votesCount'             => $answer->votesCount,
                    'hasVoteFromCurrentUser' => $answer->hasVoteFromCurrentUser,
                    'voteFromCurrentUser'    => $answer->voteFromCurrentUser,
                    'user'                   => $answer->user,
                    'shareUrl'               => urlencode(url($slug->text . '#' . 'answer-' . $answer->id)),
                ]);
            });
    }

    function store(Slug $slug)
    {
        $question = $slug->question;
        $language = $slug->language;

        $this->authorize('create', [Answer::class, $question, $language]);

        $this->validate(request(), [
            'body' => 'required',
        ]);

        $answer = new Answer;
        $answer->question()->associate($question);
        $answer->user()->associate(auth()->user());
        $answer->save();

        $edition = new Edition();
        $edition->text = request('body');
        $edition->language()->associate($language);
        $edition->user()->associate(auth()->user());
        $edition->editable()->associate($answer);
        $edition->save();

        foreach ($answer->question->votes as $vote) {
            if ($vote->user->id != $answer->user->id) {
                $vote->user->notify(new AnswerCreated($answer, $slug));
            }
        }

        return [
            'id'                     => $answer->id,
            'body'                   => $edition->text,
            'updatedAt'              => $answer->updated_at->toDateTimeString(),
            'votesCount'             => $answer->votesCount,
            'hasVoteFromCurrentUser' => $answer->hasVoteFromCurrentUser,
            'user'                   => $answer->user,
        ];
    }

    function update(Slug $slug, Answer $answer)
    {
        $this->validate(request(), [
            'body' => 'required|string',
        ]);

        $edition = new Edition();
        $edition->text = request('body');
        $edition->language()->associate($slug->language);
        $edition->user()->associate(auth()->user());
        $edition->editable()->associate($answer);
        $edition->save();

        return [
            'id'                     => $answer->id,
            'body'                   => $edition->text,
            'updatedAt'              => $answer->updated_at->toDateTimeString(),
            'votesCount'             => $answer->votesCount,
            'hasVoteFromCurrentUser' => $answer->hasVoteFromCurrentUser,
            'user'                   => $answer->user,
        ];
    }
}
