<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Merchant;
use App\Models\MerchantGallery;
use App\Models\Review;
use App\Models\GetAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{
    public function searchMerchant(Request $request)
    {
        //send request to model
        $dataInput      = $request->origin;
        $searchMerchant = $request->search;
        $data           = GetAPI::searchMerchant($searchMerchant);

        $origin       = explode(",", $dataInput);
        $jarak        = [];

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
                $dataJarak = GetAPI::getMatrix($destination, $origin);
                // $dataJarak = json_decode($data, true);

                if ( $dataJarak['rows'][0]['elements'][0]['status'] == 'OK' )
                {
                    $jarak[] = $dataJarak['rows'][0]['elements'][0]['distance']['text'];
                }
                else
                {
                    $jarak[] = "- KM";
                }
                // $jarak[] = $dataJarak;
            }
        }
        else {
            $jarak = null;
        }

        // mapping data merchant

        $dataBersih = [];
        $i = 0;

        foreach ($data as $key) {
            // get percentage
            $percentage = $this->show_percentage($key['user_id']);

            // get rating
            $rating = $this->show_rating($key['id']);

            // get gallery
            $gallery = $this->show_gallery($key['id']);

            if ( $percentage >= 100 )
            {
                $dataBersih[] = [
                    // encrypt id dengan panjang data 10 characters
                    'id'                => Crypt::encrypt($key['id']),
                    'user_id'           => Crypt::encrypt($key['user_id']),
                    // 'merchant_id'       => Crypt::encrypt($key['merchant_id']),
                    'merchant_name'     => ucwords($key['merchant_name']),
                    'jarak'             => strtoupper($jarak[$i]),
                    'percentage'        => $percentage,
                    'rating'            => $rating,
                    'gallery'           => $gallery,
                ];
                $i++;
            }
        }

        // mengurutkan data berdasarkan jarak terdekat
        $jarak = array_map(function($v){
            return floatval(str_replace(',', '', $v));
        }, $jarak);

        // mengeluarkan array ke 0
        $dataBersih = array_values($dataBersih);


        $dataBersih = $this->paginate($dataBersih, 10);
        $dataBersih->withPath('/search?search=' . $searchMerchant . '&origin=' . $dataInput);
        return view('customer.search', [
            // 'jarak' => $jarak,
            'transaction' => $dataBersih,
            'merchant_id' => $data,
            'search'      => $searchMerchant,
        ]);
    }

    // array pagination
    public function paginate($items, $perPage = 5, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage ;
        $itemstoshow = array_slice($items , $offset , $perPage);
        return new LengthAwarePaginator($itemstoshow ,$total   ,$perPage);
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
            $dataGallery[] = 'assets/img/no-image.jpg';
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

}
