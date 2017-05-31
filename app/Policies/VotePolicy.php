<?php

namespace App\Policies;

use App\User;
use App\Vote;

class VotePolicy extends Policy
{
    function create(User $user, $votable)
    {
        if ($votable->votes()->from($user)->exists()) {
            return false;
        }

        return true;
    }

    function destroy(User $user, Vote $vote)
    {
        if ($user->id != $vote->user->id) {
            return false;
        }

        return true;
    }
}
