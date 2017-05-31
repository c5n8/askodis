<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class EditSuggestionResponded extends Notification implements ShouldQueue
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
            'message' => $this->edition->translation->translatable->user->name
                . ' ' . $this->edition->status
                . ' your edit suggestion',
            'action'  => url('edits/' . $this->edition->id),
        ]);
    }
}
