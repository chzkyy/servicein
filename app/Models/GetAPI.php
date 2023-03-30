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

    protected $table = 'jarak';

    /**
     * Get Data From Database
     * @return void
     *
     */
    public static function getJarak()
    {
        // create dummy data for testing
        $data = [
            [
                'id' => 1,
                'nama' => 'Kantor Pusat',
                'alamat' => 'Jl. Raya Cikarang Barat No. 1, Cikarang Barat, Bekasi, Jawa Barat 17530',
                'latitude' => '-6.2939',
                'longitude' => '106.7459',
            ],
            [
                'id' => 2,
                'nama' => 'Kantor Cabang 1',
                'alamat' => 'Jl. Raya Cikarang Barat No. 1, Cikarang Barat, Bekasi, Jawa Barat 17530',
                'latitude' => '-6.2939',
                'longitude' => '106.7459',
            ],
            [
                'id' => 3,
                'nama' => 'Kantor Cabang 2',
                'alamat' => 'Jl. Raya Cikarang Barat No. 1, Cikarang Barat, Bekasi, Jawa Barat 17530',
                'latitude' => '-6.2939',
                'longitude' => '106.7459',
            ],
            [
                'id' => 4,
                'nama' => 'Kantor Cabang 3',
                'alamat' => 'Jl. Raya Cikarang Barat No. 1, Cikarang Barat, Bekasi, Jawa Barat 17530',
                'latitude' => '-6.2939',
                'longitude' => '106.7459',
            ],
            [
                'id' => 5,
                'nama' => 'Kantor Cabang 4',
                'alamat' => 'Jl. Raya Cikarang Barat No. 1, Cikarang Barat, Bekasi, Jawa Barat 17530',
                'latitude' => '-6.2939',
                'longitude' => '106.7459',
            ],
        ];

        return json_encode($data);
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
        return $response;
    }

    public static function searchPlace($keyword, $origin)
    {
        $url        = env('url_GoogleApi').'/place/textsearch/json?location='.$origin.'&query='.$keyword.'&radius=50000&key='.env('GOOGLE_MAP_KEY');
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
