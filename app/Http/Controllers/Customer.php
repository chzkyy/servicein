<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Customer extends Controller
{
    protected function createCust(array $data)
    {
        return Customer::create([
            'fullname'      => $data['fullname'],
            'dob'           => $data['dob'],
            'phone_number'  => $data['phone_number'],
            'gender'        => $data['gender'],
            'cust_address'  => $data['cust_address'],
        ]);
    }
}
