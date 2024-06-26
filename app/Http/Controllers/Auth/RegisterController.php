<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\GetAPI;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ChooseRole;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {
        return Validator::make($data,[
            'username'      => ['required', 'string', 'max:255', 'unique:users'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'string', 'min:8', 'confirmed', 'regex:[^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$]'],
            'tnc'           => ['accepted'],
        ])->after(function ($validator) use ($data) { // validasi email dengan api untuk mengecek apakah email valid atau tidak
            $email = $data['email'];
            $data  = GetAPI::checkEmail($email);
            $data  = json_decode($data, true);

            if($data == false){
                // message error for email not valid in english
                $validator->errors()->add('email', 'The email is not valid, please use another email!');


            }
        });
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username'      => $data['username'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
        ]);
    }

    public function index()
    {
        return view('auth.register');
    }
}
