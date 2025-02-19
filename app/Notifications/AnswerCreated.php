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

    public function __construct($answer, $slug)
    {
        $this->answer = $answer;
        $this->slug = $slug;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'actor' => $this->answer->user->name,
            'message' => 'answered your question',
            'url' => url($this->slug->text),
        ];
    }
}
