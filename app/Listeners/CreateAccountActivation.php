<?php

namespace App\Listeners;

use App\AccountActivation;
use App\Notifications\SendAccountActivationEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Events\Registered;

class CreateAccountActivation
{
    function handle(Registered $event)
    {
        $activation        = new AccountActivation;
        $activation->token = str_random(64);
        $activation->user()->associate($event->user);
        $activation->save();

        $event->user->notify(new SendAccountActivationEmail($activation->token));
    }
}
