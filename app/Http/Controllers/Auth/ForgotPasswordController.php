<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /*
    |--------------------------------------------------------------------------
    | View Password Reset Success
    |--------------------------------------------------------------------------
    |
    */

    public function success()
    {
        $auth = Auth::user();
        // auth logout
        Auth::logout();

        // redirect to login
        // dd($auth);
        return view('confirmation.password-success')->with('auth', $auth);
    }
}
