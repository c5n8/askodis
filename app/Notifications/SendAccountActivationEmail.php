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
        return (new MailMessage)
                    ->subject('Activation email')
                    ->greeting('Hello!')
                    ->line('You need to activate your email before you can start using all of our services.')
                    ->action('Activate Email', url('account/activation/' . $this->token))
                    ->line('Thank you for using our application!');
    }
}
