<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class EditionUpdated extends Notification implements ShouldQueue
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
            'actor'  => $this->edition->editable->user->name,
            'message' => $this->edition->status . ' your edit suggestion',
            'url'  => url('editions/' . $this->edition->id),
        ]);
    }
}
