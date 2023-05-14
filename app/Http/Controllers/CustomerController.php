<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function update_profile(Request $request)
    {
        // get user id
        $user_id = auth()->user()->id;

        // update data user profile
        Customer::where('id', $user_id)->update([
            'fullname'      => $request->fullname,
            'dob'           => $request->dob,
            'phone_number'  => $request->phone_number,
            'cust_address'  => $request->cust_address,
            'gender'        => $request->gender,
        ]);

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }


    public function profile()
    {
        $user_id    = auth()->user()->id;
        $customer   = Customer::where('user_id', $user_id)->first();
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
        $customer   = Customer::where('user_id', $user_id)->first();
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

        return view('customer.profile.edit',
            [
                'customer'   => $customer,
                'avatar'     => $ava,
            ]
        );
    }

    public function update_avatar(Request $request)
    {
        $user_id    = auth()->user()->id;
        $customer   = Customer::where('user_id', $user_id)->first();
        $username   = auth()->user()->username;

        // Handle File Upload
        $request->validate([
            'profile_picture' => 'required|mimes:png,jpeg,jpg|max:2048',
        ]);

        $fileName = $username.'_'.time().'.'.$request->profile_picture->extension();
        $request->profile_picture->move(public_path('assets/img/profile'), $fileName);

        // update data user profile
        User::where('id', $user_id)->update([
            'avatar' => "assets/img/profile/".$fileName,
        ]);

        return back()
            ->with('success','You have successfully upload file.')
            ->with('file', $fileName);
    }


    // function for show percentage of profile
    public function show_percentage($id)
    {
        $customer = Customer::where('user_id', $id)->first();
        $percentage = 0;

        if ($customer->fullname != '-') {
            $percentage += 20;
        }
        if ($customer->dob != '-') {
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
