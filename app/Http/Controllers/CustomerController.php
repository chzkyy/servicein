<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected function createCust(array $data)
    {
        return Customer::update([
            'fullname'      => $data['fullname'],
            'dob'           => $data['dob'],
            'phone_number'  => $data['phone_number'],
            'gender'        => $data['gender'],
            'cust_address'  => $data['cust_address'],
        ]);
    }


    public function profile()
    {
        $user_id = auth()->user()->id;
        $customer = Customer::where('user_id', $user_id)->first();
        $percentage = $this->show_percentage($user_id);
        return view('customer.profile.index',
            [
                'customer' => $customer,
                'percentage' => $percentage,
            ]
        );
    }

    // function for show percentage of profile
    public function show_percentage($id)
    {
        $customer = Customer::where('user_id', $id)->first();
        $percentage = 0;

        if ($customer->fullname != '') {
            $percentage += 20;
        }
        if ($customer->dob != '') {
            $percentage += 20;
        }
        if ($customer->phone_number != '') {
            $percentage += 20;
        }
        if ($customer->gender != '') {
            $percentage += 20;
        }
        if ($customer->cust_address != '') {
            $percentage += 20;
        }

        return $percentage;
    }

}
