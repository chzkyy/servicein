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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'fullname'  => ['required', 'string', 'max:255'],
            'username'  => ['required', 'string', 'max:255', 'unique:users'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:8', 'confirmed', 'regex:[^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$]'],
        ])->after(function ($validator) use ($data) { // validasi email dengan api untuk mengecek apakah email valid atau tidak
            $email = $data['email'];
            $data  = GetAPI::checkEmail($email);
            $data  = json_decode($data, true);

            if($data == false){
                $validator->errors()->add('email', 'Email tidak valid, silahkan cek kembali email anda');
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
            'fullname'  => $data['fullname'],
            'username'  => $data['username'],
            'email'     => $data['email'],
            'role'      => 'User',
            'password'  => Hash::make($data['password']),
        ]);
    }

    public function AdminRegister(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->createAdmin($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                ? new JsonResponse([], 201)
                : redirect($this->redirectPath());
    }

    protected function createAdmin(array $data)
    {

        return User::create([
            'fullname'  => $data['fullname'],
            'username'  => $data['username'],
            'email'     => $data['email'],
            'role'      => 'Admin',
            'password'  => Hash::make($data['password']),
        ]);
    }

    public function index()
    {
        return view('auth.register');
    }
}
