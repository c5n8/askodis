<?php

namespace App\Models;

use App\Traits\CamelCaseJsonAttribute;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use CamelCaseJsonAttribute;
}
