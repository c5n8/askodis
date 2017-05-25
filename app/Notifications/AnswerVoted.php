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
        return ([
            'message' => $this->vote->user->name . ' voted your answer',
            'action'  => url('questions/' . $this->vote->votable->question->id),
        ]);
    }
}
