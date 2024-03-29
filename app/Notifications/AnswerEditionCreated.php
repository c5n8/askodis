<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AnswerEditionCreated extends Notification implements ShouldQueue
{
    use Queueable;

    private $edition;

    function __construct($edition)
    {
        $this->edition = $edition;
    }

    function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    function toArray($notifiable)
    {
        return ([
            'actor'  => $this->edition->user->name,
            'message' => 'suggested edit to your answer',
            'url'  => url('editions/' . $this->edition->id),
        ]);
    }
}
