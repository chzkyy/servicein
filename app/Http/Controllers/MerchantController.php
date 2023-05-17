<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Merchant;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // hanya role merchant yang bisa mengakses
        $this->middleware(['merchant']);
    }

    public function index()
    {
        return view('adminToko.testMaps');
    }


    protected function update_merchant(array $data)
    {
        return Merchant::update([
            'merchant_name'         => $data['merchant_name'],
            'merchant_desc'         => $data['merchant_desc'],
            'merchant_address'      => $data['merchant_address'],
            'open_hour'             => $data['open_hour'],
            'close_hour'            => $data['close_hour'],
            'phone_number'          => $data['phone_number'],
            'geo_location'          => $data['geo_location'],
        ]);
    }

    protected function createMerchantGallery(array $data)
    {
        return MerchantGallery::create([
            'merchant_id'           => $data['merchant_id'],
            'images'                => $data['images'],
        ]);
    }

    public function profile()
    {
        $user_id    = auth()->user()->id;
        $merchant   = Merchant::where('user_id', $user_id)->first();
        $percentage = $this->show_percentage($user_id);
        $ava        = auth()->user()->avatar;

        if ( $ava == null )
        {
            $ava = NULL;
        }
        else if ( $ava == str_contains($ava, 'https') )
        {
            $ava = $ava;
        }
        else if( $ava == str_contains($ava, 'assets/img/profile')) {
            $ava = asset($ava);
        }

        return view('adminToko.index',
            [
                'merchant'   => $merchant,
                'percentage' => $percentage,
                'avatar'     => $ava,
            ]
        );
    }

    public function edit_profile()
    {
        $user_id    = auth()->user()->id;
        $merchant   = Merchant::where('user_id', $user_id)->first();
        $percentage = $this->show_percentage($user_id);
        $ava        = auth()->user()->avatar;

        if ( $ava == null )
        {
            $ava = NULL;
        }
        else if ( $ava == str_contains($ava, 'https') )
        {
            $ava = $ava;
        }
        else if( $ava == str_contains($ava, 'assets/img/profile')) {
            $ava = asset($ava);
        }
        return view ('adminToko.edit',
            [
                'merchant'   => $merchant,
                'percentage' => $percentage,
                'avatar'     => $ava,
            ]
        );
    }

    // function for show percentage of profile
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
