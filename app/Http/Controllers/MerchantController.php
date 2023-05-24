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


    protected function update_merchant(Request $request)
    {
        $user_id = auth()->user()->id;

        Merchant::where('user_id', $user_id)->update([
            'merchant_name'         => $request->merchant_name,
            'merchant_desc'         => $request->merchant_desc,
            'merchant_address'      => $request->merchant_address,
            'open_hour'             => $request->open_hour,
            'close_hour'            => $request->close_hour,
            'phone_number'          => $request->phone_number,
            'geo_location'          => $request->geo_location,

        ]);

        return redirect()->route('profile.admin')->with('success', 'Profile updated successfully');
    }

    protected function createMerchantGallery(array $data)
    {
        return MerchantGallery::create([
            'merchant_id'           => $data['merchant_id'],
            'images'                => $data['images'],
        ]);
    }

    public function merchant()
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

    public function edit_merchant()
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

    public function update_avatar(Request $request)
    {
        // get user id
        $user_id    = auth()->user()->id;
        // get username
        $username   = auth()->user()->username;

        // Handle File Upload
        $request->validate([
            'profile_picture' => 'required|mimes:png,jpeg,jpg|max:2048',
        ]);

        $fileName = $username.'.'.$request->profile_picture->extension();
        $request->profile_picture->move(public_path('assets/img/profile'), $fileName);

        // update data user profile
        User::where('id', $user_id)->update([
            'avatar' => "assets/img/profile/".$fileName,
        ]);

        return redirect()->route('profile.admin')->with('success','You have successfully upload file.')->with('file', $fileName);
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
