<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends BaseResetPassword implements ShouldQueue
{
    use Queueable;

    public function toMail($notifiable)
    {
        app()->setLocale($notifiable->locale->code);

        return (new MailMessage)
            ->line(__('You are receiving this email because we received a password reset request for your account.'))
            ->action(__('Reset Password'), url(config('app.url').route('password.reset', $this->token, false)))
            ->line(__('If you did not request a password reset, no further action is required.'));
    }
}
