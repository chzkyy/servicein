<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //  check guest
        $guest = Auth::guest();
        if ($guest) {
            return view('home');
        } else {
            // get user role
            $role = Auth::user()->role;
            if ($role == NULL) {
                return redirect()->to('/choose-role');
            } else {
                return view('home');
            }
        }
    }
}
