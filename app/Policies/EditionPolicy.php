<?php

namespace App\Policies;

use App\Edition;
use App\Question;
use App\User;

class EditionPolicy extends Policy
{
    function create(User $user, $editable, Language $language)
    {
        if ($editable->edition()->inLanguage($language)->exists()) {
            return false;
        }

        return true;
    }

    function view(User $user, Edition $edition)
    {
        if ($edition->status == 'pending') {
            if ($edition->editable->user->id != $user->id) {
                return false;
            }
        }

        return true;
    }

    function update(User $user, Edition $edition)
    {
        if ($edition->editable_type == 'answer') {
            if ($user->id != $edition->editable->user->id) {
                return false;
            }
        }

        return true;
    }
}
