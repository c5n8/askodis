<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AnswerVoteCreated extends Notification implements ShouldQueue
{
    use Queueable;

    private $vote;
    private $slug;

    function __construct($vote, $slug)
    {
        $this->vote = $vote;
        $this->slug = $slug;
    }

    function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    function toArray($notifiable)
    {
        return ([
            'actor'  => $this->vote->user->name,
            'message' => 'voted your answer',
            'url'  => url($this->slug->text),
        ]);
    }
}
