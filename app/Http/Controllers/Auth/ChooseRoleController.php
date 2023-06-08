<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ChooseRoleController extends Controller
{
    public function chooseRole()
    {
        $user = Auth::user();
        // check user login
        if ($user) {
            // check user role
            if ($user->role == 'Admin') {
                return redirect()->to('/');
            } elseif ($user->role == 'User') {
                return redirect()->to('/');
            } else {
                return view('auth.choose-role');
            }
        } else {
            return redirect()->to('/login');
        }
    }

    public function storeRole(Request $request)
    {
        // get user id
        $id = Auth::user()->id;

        // update role
        User::where('id', $id)->update([
            'role' => $request->role
        ]);

        // check apakah user sudah memiliki data profile
        $check_merchant = Merchant::where('user_id', $id)->first();
        $check_customer = Customer::where('user_id', $id)->first();

        //create data user profile based on role
        switch ($request->role) {
            case 'Admin':
                $user = User::find($id);
                // check apakah user sudah memiliki data profile merchant
                if (!$check_merchant) {
                    Merchant::create([
                        'user_id'               => $user->id,
                        'merchant_name'         => '-',
                        'merchant_desc'         => '-',
                        'merchant_address'      => '-',
                        'open_hour'             => '8:00',
                        'close_hour'            => '17:00',
                        'phone_number'          => '-',
                        'geo_location'          => '-,-',
                    ]);
                }
                return redirect()->to('/');
                break;
            case 'User':
                $user = User::find($id);
                if (!$check_customer) {
                    Customer::create([
                        'user_id'       => $user->id,
                        'fullname'      => '-',
                        'phone_number'  => '-',
                        'gender'        => '-',
                        'cust_address'  => '-',
                    ]);
                }
                return redirect()->to('/');
            default:
                return redirect()->to('/');
                break;
        }

        // set add role to session
        $request->session()->put('role', $request->role);

        // echo data
        // echo $request->role;
        return redirect()->to('/');
    }
}
