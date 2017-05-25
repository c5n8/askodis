<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class NotificationController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function index()
    {
        if (auth()->user()->unreadNotifications()->exists()) {
            auth()->user()->unreadNotifications()->update(['read_at' => Carbon::now()]);
        }

        return auth()->user()->notifications()
            ->when(request()->has('before'), function ($query) {
                return $query->where(
                    'created_at',
                    '<',
                    auth()->user()->notifications()->find(request('before'))->created_at
                );
            })
            ->limit(10)
            ->get();
    }

    function show($id)
    {
        return auth()->user()->notifications()->find($id);
    }
}
