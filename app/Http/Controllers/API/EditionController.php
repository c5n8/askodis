<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Edition;
use App\Notifications\EditSuggestionResponded;

class EditionController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function update($id)
    {
        $edition = Edition::withoutGlobalScopes()->findOrFail($id);

        if ($edition->translation->translatable->user->id != auth()->user()->id) {
            abort(403);
        }

        $this->validate(request(), [
            'status' => 'required|in:accepted,rejected',
        ]);

        $edition->status = request('status');
        $edition->save();

        $edition->user->notify(new EditSuggestionResponded($edition));

        return $edition;
    }
}
