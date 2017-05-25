<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class UnreadNotificationController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function update()
    {
        if (auth()->user()->unreadNotifications()->exists()) {
            auth()->user()->unreadNotifications()->update(['read_at' => Carbon::now()]);
        }

        return response()->json(null, 204);
    }
}
