<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AnswerVoted extends Notification implements ShouldQueue
{
    use Queueable;

    private $vote;

    function __construct($vote)
    {
        $this->vote = $vote;
    }

    function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    function toArray($notifiable)
    {
        $answer = $this->vote->votable;
        $language = $answer->translations()->first()->language;
        $slug = $answer->question->slugs()->InLanguage($language)->first();

        return ([
            'message' => $this->vote->user->name . ' voted your answer',
            'action'  => url($slug->text),
        ]);
    }
}
