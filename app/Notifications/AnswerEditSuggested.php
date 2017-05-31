<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AnswerEditSuggested extends Notification implements ShouldQueue
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
            'message' => $this->edition->user->name . ' suggested edit to your answer',
            'action'  => url('edits/' . $this->edition->id),
        ]);
    }
}
