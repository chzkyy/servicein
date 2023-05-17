<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    public function redirectTo()
    {
        $role = Auth::user()->role;
        switch ($role) {
            case 'User':
                return '/';
                break;
            case 'Admin':
                return '/';
                break;
            case NULL:
                return '/choose';
                break;
            default:
                return '/';
                break;
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Membuat function untuk login dengan username
     *
     */

    public function username()
    {
        $loginValue = request('username');
        // Cek apakah inputan berupa email atau username
        $this->username = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        // Merge inputan ke dalam request
        request()->merge([$this->username => $loginValue]);
        // Return login type
        return property_exists($this, 'username') ? $this->username : 'email';
    }


    /**
     *  Membuat custome error untuk login
     *
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'email' => 'Email/Username or password is incorrect!'
        ]);
    }
}
