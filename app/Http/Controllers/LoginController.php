<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;

class LoginController extends Controller
{
    public function authenticated(Request $request, $user)
    {
        if (!$user->hasVerifiedEmail()) {
            auth()->logout();

            return redirect('/login')->with('error', 'You need to verify your email address before logging in.');
        }
    }
}
