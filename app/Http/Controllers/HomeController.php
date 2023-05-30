<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Merchant;
use App\Models\Review;
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

        // get all merchant
        $all = Merchant::all();
        $merchant = array();
        $data['data'] = array();
        $rate = [];

        // mengeluarkan data berdasakann persentase > 75%
        foreach ($all as $item) {
            if ($this->show_percentage($item->user_id) > 75) {
                $merchant[] = $item;

                // show rating
                $rating = $this->show_rating($item->user_id );
                $merchant[] = $rating;


            }

        }

        return $data;

        // check if user is guest
        // if ($guest) {
        //     return view('home',[
        //         'merchant' => $merchant,
        //     ]);
        // }
        // else {
        //     $verified   = Auth::user()->email_verified_at;
        //     $role       = Auth::user()->role;
        //     // check if user is verified
        //     if ($verified) {
        //         // check if user has role
        //         if ($role == NULL) {
        //             return redirect()->to('/choose');
        //         }
        //         else {
        //             return view('home',);
        //         }
        //     }
        //     else {
        //         return redirect()->route('verification.notice');
        //     }
        // }
    }

    public function show_rating($id)
    {
        $rating = Review::where('merchant_id', $id)->first();

        // if rating is nor available
        if($rating == null) {
            $rating = 0;
        }
        else {
            $rating = $rating->avg('rating');
        }

        return $rating;
    }

    public function show_percentage($id)
    {
        $merchant = Merchant::where('user_id', $id)->first();
        $percentage = 0;

        if ($merchant->merchant_name != '-') {
            $percentage += 100/7;
        }
        if ($merchant->merchant_desc != '-') {
            $percentage += 100/7;
        }
        if ($merchant->merchant_address != '-') {
            $percentage += 100/7;
        }
        if ($merchant->phone_number != '-') {
            $percentage += 100/7;
        }
        if ($merchant->open_hour != '-') {
            $percentage += 100/7;
        }
        if ($merchant->close_hour != '-') {
            $percentage += 100/7;
        }
        if ($merchant->geo_location != '-') {
            $percentage += 100/7;
        }

        return round($percentage);
    }
}
