<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Customer;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // hanya role customer yang bisa mengakses
        $this->middleware(['customer']);
    }


    public function update_profile(Request $request)
    {
        // get user id
        $user_id = auth()->user()->id;

        // update data user profile
        Customer::where('user_id', $user_id)->update([
            'fullname'      => $request->fullname,
            'dob'           => $request->dob,
            'phone_number'  => $request->phone_number,
            'cust_address'  => $request->cust_address,
            'gender'        => $request->gender,
        ]);

        return back()->with('success', 'Profile updated successfully');
    }


    public function profile()
    {
        $user_id    = auth()->user()->id;
        // get data user profile
        $customer   = Customer::where('user_id', $user_id)->first();
        // get percentage
        $percentage = $this->show_percentage($user_id);
        // get avatar
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

        return view('customer.profile.index',
            [
                'customer'   => $customer,
                'percentage' => $percentage,
                'avatar'     => $ava,
            ]
        );
    }

    public function edit_profile()
    {
        $user_id    = auth()->user()->id;
        // get data user profile
        $customer   = Customer::where('user_id', $user_id)->first();
        // get avatar
        $ava        = auth()->user()->avatar;

        $dob        = $customer->dob;

        if ($dob != NULL) {
            $dob = date('Y-m-d', strtotime($dob));
        } else {
            $dob = NULL;
        }

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

        return view('customer.profile.edit',
            [
                'dob'        => $dob, // 'Y-m-d'
                'customer'   => $customer,
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
        $customer = Customer::where('user_id', $id)->first();
        $percentage = 0;

        if ($customer->fullname != '-') {
            $percentage += 20;
        }
        if ($customer->dob != NULL) {
            $percentage += 20;
        }
        if ($customer->phone_number != '-') {
            $percentage += 20;
        }
        if ($customer->gender != '-') {
            $percentage += 20;
        }
        if ($customer->cust_address != '-') {
            $percentage += 20;
        }

        return $percentage;
    }

}
