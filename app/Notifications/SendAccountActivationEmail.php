<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendAccountActivationEmail extends Notification implements ShouldQueue
{
    use Queueable;

    protected $token;

    function __construct($token)
    {
        $this->token = $token;
    }

    function via($notifiable)
    {
        return ['mail'];
    }

    function toMail($notifiable)
    {
        app()->setLocale($notifiable->locale->code);

        return (new MailMessage)
            ->subject(__('Account activation email'))
            ->line(__('You need to activate your account before you can start using Askodis.'))
            ->action(__('Activate Account'), url('account/activation/' . $this->token))
            ->line(__('Thank you for using Askodis!'));
    }
}
