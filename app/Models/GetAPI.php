<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Http;
use App\Models\GetAPI;
use DB;

class GetAPI extends Model
{
    use HasFactory;

    protected $table = 'merchant';

    /**
     * Get Data From Database
     * @return void
     *
     */
    public static function getJarak($data)
    {
        // send data to static function result
        // $data = GetAPI::result($data);
        return $data;
    }

    public static function merchant()
    {
        $data = DB::table('merchant')
            ->join('users', 'merchant.user_id', '=', 'users.id')
            ->select('merchant.*', 'users.email')
            ->get();

        $dataBersih = [];

        // get geo location
        foreach ($data as $item) {
            $geo = $item->geo_location;
            $geo = explode(',', $geo);
            $item->geo_location = $geo;
        }

        // mapping data to array
        foreach ($data as $item) {

            if ( $item->geo_location[0] != '-' ) {
                $dataBersih[] = [
                    'id'                => $item->id,
                    'user_id'           => $item->user_id,
                    'merchant_name'     => $item->merchant_name,
                    'merchant_desc'     => $item->merchant_desc,
                    'merchant_address'  => $item->merchant_address,
                    'open_hour'         => $item->open_hour,
                    'close_hour'        => $item->close_hour,
                    'phone_number'      => $item->phone_number,
                    'latitude'          => $item->geo_location[0],
                    'longitude'         => $item->geo_location[1],
                    'email'             => $item->email,
                ];
            }
            else {
                $dataBersih[] = [
                    'id'                => $item->id,
                    'user_id'           => $item->user_id,
                    'merchant_name'     => $item->merchant_name,
                    'merchant_desc'     => $item->merchant_desc,
                    'merchant_address'  => $item->merchant_address,
                    'open_hour'         => $item->open_hour,
                    'close_hour'        => $item->close_hour,
                    'phone_number'      => $item->phone_number,
                    'latitude'          => null,
                    'longitude'         => null,
                    'email'             => $item->email,
                ];
            }
        }

        return $dataBersih;
    }

    /**
     * Request API Google Map
     *
     * @param $destination
     * @param $origin
     * @param $keyword
     * @return void
     *
     */

    public static function Maps()
    {
        $url        = env('url_GoogleApi').'/js?key='.env('GOOGLE_MAP_KEY').'&callback=initialize';
        $curl        = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL             => $url,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => '',
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 0,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => 'GET',
            CURLOPT_HTTPHEADER      => array(
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public static function getMatrix($destination, $origin)
    {
        $url        = env('url_GoogleApi').'/distancematrix/json?destinations='.$destination.'&origins='.$origin.'&units=km&key='.env('GOOGLE_MAP_KEY');
        $curl        = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL             => $url,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => '',
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 0,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => 'GET',
            CURLOPT_HTTPHEADER      => array(
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }

    public static function searchPlace($keyword, $origin)
    {
        $url        = env('url_GoogleApi').'/place/textsearch/json?location='.$origin.'&query='.$keyword.'&radius=100000&key='.env('GOOGLE_MAP_KEY');
        $curl        = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL             => $url,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => '',
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 0,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => 'GET',
            CURLOPT_HTTPHEADER      => array(
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public static function reverseGeocode($geo)
    {
        $url        = env('url_GoogleApi').'/geocode/json?location_type=ROOFTOP&result_type=street_address&latlng='.$geo.'&key='.env('GOOGLE_MAP_KEY');
        $curl        = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL             => $url,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => '',
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 0,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => 'GET',
            CURLOPT_HTTPHEADER      => array(
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    /**
     * Request API Email Verification
     * @param $email
     * @return bool
     *
     */

    public static function checkEmail($email)
    {
        $url    = 'https://emailverification.whoisxmlapi.com/api/v2?apiKey='.env('emailValidationAPI').'&emailAddress='.$email;
        $curl   = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL             => $url,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => '',
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 0,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => 'GET',
        ));

        $res = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($res);

        // print_r($response);
        if($response->dnsCheck == "false" || $response->disposableCheck == "true"){
            return false;
            // print_r("false");
        }else{
            if($response->smtpCheck == "false"){
                // print_r("false");
                return false;
            }
            else {
                print_r("true");
                return true;
            }
        };
    }
}
