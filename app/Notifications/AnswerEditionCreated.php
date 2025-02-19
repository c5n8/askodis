<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AnswerEditionCreated extends Notification implements ShouldQueue
{
    use Queueable;

    private $edition;

    public function __construct($edition)
    {
        $this->edition = $edition;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'actor' => $this->edition->user->name,
            'message' => 'suggested edit to your answer',
            'url' => url('editions/'.$this->edition->id),
        ];
    }
}
