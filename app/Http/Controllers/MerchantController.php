<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MerchantController extends Controller
{
    //

    public function index()
    {
        return view('adminToko.testMaps');
    }


    protected function createMerchant(array $data)
    {
        return Merchant::create([
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
}
