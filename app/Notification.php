<?php

namespace App;

use App\Traits\CamelCaseJsonAttribute;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use CamelCaseJsonAttribute;
}
