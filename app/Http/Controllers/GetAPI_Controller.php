<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GetAPI;
use Illuminate\Support\Facades\Mail;


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
        // get data fom table jarak
        $data   = GetAPI::getJarak();
        $data   = json_decode($data, true);
        $jarak  = [];
        //send request to model
        $dataInput = $request->input('origin');
        $origin = explode(",", $dataInput);

        // hitung panjang karakter dari titik
        $pGeoOrigin = strlen($origin[0]) - strlen(substr($origin[0], 0, -7));

        if ( $pGeoOrigin != 6 )
        {
            // membatasi panjang karakter di belakang titik (6 karakter)
            $origin = substr($origin[0], 0, -7) . "," . substr($origin[1], 0, -7);
        }


        // print_r($origin);

        if( $origin != null )
        {
            foreach ($data as $key) {
                $lat = $key['latitude'];
                $lng = $key['longitude'];
                $destination = $lat . "," . $lng;
                $data = GetAPI::getMatrix($destination, $origin);
                $data = json_decode($data, true);

                // push data to array
                $jarakDalamKM        = $data['rows'][0]['elements'][0]['distance']['text'];
                $jarak[]['distance'] = $jarakDalamKM;
            }
        }
        else {
            $jarak = null;
        }

        // print_r($jarak);
        $json       = json_encode($jarak,JSON_PRETTY_PRINT);
        // echo $json;

        //create response
        if($jarak != null){
            $response = [
                'message'   => 'Success',
                'data'      => json_decode($json)
            ];
            return response()->json($response, 200);
        }else if($origin == null){
            $response = [
                'message'   => 'Failed',
                'data'      => 'Failed to get data origin'
            ];
            return response()->json($response, 400);
        }else{
            $response = [
                'message'   => 'Failed',
                'data'      => null
            ];
            return response()->json($response, 404);
        }
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
