<?php

namespace App;

use App\Traits\CamelCaseJsonAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use CamelCaseJsonAttribute;
}
