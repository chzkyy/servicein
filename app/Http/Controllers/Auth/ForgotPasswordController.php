<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


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


    public function ChangePassword()
    {
        return view('auth.passwords.change');
    }

    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old-password' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:[^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$]'],
        ]);


        #Match The Old Password
        if (!Hash::check($request->input('old-password'), auth()->user()->password)) {
            return back()->withErrors([
                'old-password' => 'The old password is incorrect.'
            ])
            ->withInput();
        }

        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->password)
        ]);

        // redirect to profile with success message
        return back()->with('success', 'Password has been changed!');
    }
}
