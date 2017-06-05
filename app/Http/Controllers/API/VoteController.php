<?php

namespace App\Http\Controllers\API;

use App\Vote;

class VoteController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function destroy(Vote $vote)
    {
        $this->authorize('destroy', $vote);

        $vote->delete();

        return response()->json(null, 204);
    }
}
