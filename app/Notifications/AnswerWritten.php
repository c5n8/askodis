<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AnswerWritten extends Notification implements ShouldQueue
{
    use Queueable;

    private $answer;

    function __construct($answer)
    {
        $this->answer = $answer;
    }

    function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    function toArray($notifiable)
    {
        $language = $this->answer->translations()->first()->language;
        $slug = $this->answer->question->slugs()->InLanguage($language)->first();

        return ([
            'message' => $this->answer->user->name . ' answered your question',
            'action'  => url($slug->text),
        ]);
    }
}
