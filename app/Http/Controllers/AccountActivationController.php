<?php

namespace App\Http\Controllers;
use App\Notifications\SendAccountActivationEmail;
use Carbon\Carbon;

class AccountActivationController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        if (! auth()->user()->activation()->exists()) {
            return redirect('/');
        }

        return view('auth.activation');
    }

    function activate($token)
    {
        if (! auth()->user()->activation()->exists()) {
            return redirect('/');
        }

        $activation = auth()->user()->activation()->where('token', $token)->firstOrFail();

        $activation->delete();

        return redirect('/')
            ->with('status', 'success')
            ->with('message', 'You successfully activated your email!');
    }

    function resend()
    {
        if (! auth()->user()->activation()->exists()) {
            return redirect('/');
        }

        $activation = auth()->user()->activation;

        if ($activation->created_at->diffInHours(Carbon::now()) > 1) {
            auth()->user()->notify(new SendAccountActivationEmail($activation->token));
        }

        return redirect('account/activation');
    }
}
