<?php

namespace App\Policies;

use App\Edition;
use App\User;

class EditionPolicy extends Policy
{
    function update(User $user, Edition $edition)
    {
        if ($edition->editable_type == 'answer') {
            if ($user->id != $edition->editable->user->id) {
                return false;
            }

            return true;
        }

        return true;
    }
}
