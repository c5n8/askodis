<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AnswerCreated extends Notification implements ShouldQueue
{
    use Queueable;

    private $answer;
    private $slug;

    function __construct($answer, $slug)
    {
        $this->answer = $answer;
        $this->slug = $slug;
    }

    function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    function toArray($notifiable)
    {
        return ([
            'message' => $this->answer->user->name . ' answered your question',
            'action'  => url($this->slug->text),
        ]);
    }
}
