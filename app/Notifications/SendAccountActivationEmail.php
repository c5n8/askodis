<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendAccountActivationEmail extends Notification implements ShouldQueue
{
    use Queueable;

    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        app()->setLocale($notifiable->locale->code);

        return (new MailMessage)
            ->subject(__('Account activation email'))
            ->line(__('You need to activate your account before you can start using Askodis.'))
            ->action(__('Activate Account'), url('account/activation/'.$this->token))
            ->line(__('Thank you for using Askodis!'));
    }
}
