<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use App\Slug;

class UserQuestionController extends Controller
{
    function index(User $user)
    {
        $questions = Slug::whereHas('question', function ($query) use ($user) {
                $query->whereHas('answers', function ($query) use ($user) {
                        $query->from($user);
                    });
            })
            ->orderBy('created_at', 'desc')
            ->when(request()->has('before'), function ($query) {
                return $query->where('id', '<', request('before'));
            })
            ->paginate(10)
            ->transform(function ($question) use ($user) {
                $question = $question->toArray();
                $question['hasAnswer'] = false;
                $question['topAnswer'] = null;

                if (count($question['answers']) > 0) {
                    $question['hasAnswer'] = true;
                    $question['topAnswer'] = collect($question['answers'])->first(function ($answer) use ($user) {
                        return $answer['user']['username'] == $user->username;
                    });
                }

                unset($question['answers']);

                return $question;
            });

        return $questions;
    }
}
