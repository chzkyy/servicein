<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Merchant;
use App\Models\MerchantGallery;
use App\Models\Review;
use App\Models\GetAPI;
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
        // check if user is guest
        if ($guest) {
            return view('home');
        }
        else {
            $verified   = Auth::user()->email_verified_at;
            $role       = Auth::user()->role;
            // check if user is verified
            if ($verified) {
                // check if user has role
                if ($role == NULL) {
                    return redirect()->to('/choose');
                }
                else if( $role == 'Admin' ) {
                    return redirect()->to('/admin');
                }
                elseif ( $role ==  'Super_Admin' )
                {
                    return redirect()->to('/super-admin');
                }
                else {
                    return view('home');
                }
            }
            else {
                return redirect()->route('verification.notice');
            }
        }
    }
}
