<?php

namespace App\Http\Controllers\API;

use App\Edition;
use App\Notifications\EditionUpdated;

class EditionController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function update(Edition $edition)
    {
        $this->authorize('update', $edition);

        $this->validate(request(), [
            'status' => 'required|in:accepted,rejected',
        ]);

        $edition->status = request('status');
        $edition->save();

        $edition->user->notify(new EditionUpdated($edition));

        return $edition;
    }
}
