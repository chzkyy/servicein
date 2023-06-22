<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GetAPI;
use App\Models\Merchant;
use App\Models\MerchantGallery;
use App\Models\Review;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GetAPI_Controller extends Controller
{

    // get addres name
    public function getLocation(Request $request)
    {
        $geometry  = $request->input('geo');
        $data = GetAPI::reverseGeocode($geometry);
        $data = json_decode($data, true);

        $address = $data['results'][0]['formatted_address'];

        //create response
        if($address != null){
            $response = [
                'message'   => 'Success',
                'data'      => $address
            ];
            return response()->json($response, 200);
        }else{
            $response = [
                'message'   => 'Failed',
                'data'      => null,
            ];
            return response()->json($response, 404);
        }
    }

    public function getMatrix(Request $request)
    {
        // get data from getJarak
        $data       = GetAPI::merchant();
        //send request to model
        $dataInput  = $request->input('origin');
        $origin     = explode(",", $dataInput);
        $jarak      = [];
        $i          = 0;

        // hitung panjang karakter dari titik
        $pGeoOrigin = strlen($origin[0]) - strlen(substr($origin[0], 0, -7));

        if ( $pGeoOrigin != 6 )
        {
            // membatasi panjang karakter di belakang titik (6 karakter)
            $origin = substr($origin[0], 0, -7) . "," . substr($origin[1], 0, -7);
        }

        if( $origin != null )
        {
            foreach ($data as $key) {
                $lat = $key['latitude'];
                $lng = $key['longitude'];
                $destination = $lat . "," . $lng;
                $dataJarak   = GetAPI::getMatrix($destination, $origin);
                // $dataJarak = json_decode($data, true);
                $jarak[]    = $dataJarak;

                // if ( $dataJarak['rows'][0]['elements'][0]['status'] == 'OK' )
                // {
                //     $jarak[] = $dataJarak['rows'][0]['elements'][0]['distance']['text'];
                // }
                // else
                // {
                //     $jarak[] = "- KM";
                // }
            }
        }
        else {
            $jarak = null;
        }

        // mapping data merchant
        $dataBersih = [];
        $i = 0;

        foreach ($data as $item) {
            // get percentage
            $percentage = $this->show_percentage($item['user_id']);
            // get rating
            $rating = $this->show_rating($item['id']);
            // get gallery
            $gallery = $this->show_gallery($item['id']);

            $dataBersih[] = [
                // encrypt id dengan panjang data 10 characters
                'status_account'    => $item['status_account'],
                'id'                => Crypt::encrypt($item['id']),
                'user_id'           => Crypt::encrypt($item['user_id']),
                'merchant_name'     => ucwords($item['merchant_name']),
                'merchant_desc'     => ucfirst($item['merchant_desc']),
                'merchant_address'  => $item['merchant_address'],
                'open_hour'         => $item['open_hour'],
                'close_hour'        => $item['close_hour'],
                'phone_number'      => $item['phone_number'],
                'latitude'          => $item['latitude'],
                'longitude'         => $item['longitude'],
                'email'             => $item['email'],
                'jarak'             => $jarak[$i],
                'percentage'        => $percentage,
                'rating'            => $rating,
                'gallery'           => $gallery,
            ];
            $i++;
        }

        // mengurutkan data berdasarkan jarak terdekat
        $jarak = array_map(function($v){
            return floatval(str_replace(',', '', $v));
        }, $jarak);

        //create response
        $response = [
            'message'   => 'Success',
            'data'      => $dataBersih,
        ];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
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

    public function show_gallery($id)
    {
        $dataGallery = [];
        $gallery = MerchantGallery::where('merchant_id', $id)->first();
        if ($gallery == null) {
            $dataGallery = [];
        }
        else {
            $gallery = MerchantGallery::where('merchant_id', $id)->get();
            foreach ($gallery as $item) {
                $dataGallery[] = $item['images'];
            }
        }

        return $dataGallery;
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
        if ($merchant->geo_location != '-,-') {
            $percentage += 100/7;
        }

        return round($percentage);
    }

    // create controller for api searchPlace?origin={input}&place={iput}
    public function searchPlace(Request $request)
    {
        $origin     = $request->query('geo');
        $keyword    = $request->query('q');

        $keyword    = urlencode($keyword);

        $data = GetAPI::searchPlace($keyword, $origin);
        $data = json_decode($data, true);

        // print_r($data);

        $arrHasil = [];
        // create response for lat and lng
        foreach($data['results'] as $key){
            $lat = $key['geometry']['location']['lat'];
            $lng = $key['geometry']['location']['lng'];
            $place = $key['name'];
            $address = $key['formatted_address'];

            $response = [
                'message'   => 'Success',
                'data'      => [
                    'lat'       => $lat,
                    'lng'       => $lng,
                    'place'     => $place,
                    'address'   => $address
                ]
            ];

            $arrHasil[] = $response;
        }

        // datatype json
        // $arrHasil = json_encode($arrHasil, JSON_PRETTY_PRINT);
        return response()->json($arrHasil, 200);

        // print_r(json_encode($data));
    }

    public function MapsJs()
    {
        $data = GetAPI::Maps();
        print_r($data);
    }

}
