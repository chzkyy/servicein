<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Merchant;
use App\Models\MerchantGallery;
use App\Models\ReviewImage;
use App\Models\Review;
use App\Models\GetAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;


class DetailMerchantController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // hanya role customer yang bisa mengakses
        $this->middleware(['customer']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        try {
            $id_merchant    = Crypt::decrypt($id);
            $merchant       = Merchant::find($id_merchant);
            $review         = Review::where('merchant_id', $id_merchant)->first();
            $gallery        = $this->show_gallery($id_merchant);
            $dataReview     = [];
            $dataImage      = [];

            if(!$merchant){
                return abort(404, 'Data Not Found!');
            }
            else {
                if($review == null) {
                    $dataReview = null;
                }
                else {
                    $review = Review::where('merchant_id', $id_merchant)->get();
                    // dd($review);
                    foreach ($review as $item) {
                        $username = User::where('id', $item->user_id)->first();
                        $image_review = ReviewImage::where('review_id', $item->id)->first();
                        if($image_review == null) {
                            $dataImage = null;
                        }
                        else {
                            $image_review = ReviewImage::where('review_id', $item->id)->get();
                            foreach ($image_review as $image) {
                                $dataImage[] = [
                                    'id'        => $image->id,
                                    'image'     => $image->image,
                                ];
                            }
                        }
                        $avatar = $username->avatar;

                        if($avatar == null) {
                            $username->avatar = 'assets/img/profile_picture.png';
                        }

                        $dataReview[] = [
                            'id'                => $item['id'],
                            'avatar'            => $username->avatar,
                            'username'          => $username->username,
                            'rating'            => $item['rating'],
                            'review'            => $item['review'],
                            'image_review'      => $dataImage,
                            'created_at'        => $item['created_at'],
                        ];
                    }
                }

                return view('customer.transaction.detailMerchant', [
                    'id'        => Crypt::encrypt($merchant->id),
                    'gallery'   => $gallery,
                    'review'    => $dataReview,
                ]);
            }
        } catch (DecryptException $e) {
            $id_merchant = null;
            $e->getMessage();
            return abort(404, 'Data Not Found!');
        }
    }

    public function getDetail(Request $request)
    {
        // get data from getJarak
        $data         = GetAPI::merchant();
        //send request to model
        $dataInput    = $request->input('origin');
        $id_merchant  = $request->input('merchant_id');
        $id_merchant  = Crypt::decrypt($id_merchant);

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

        // mapping data merchant dan mengambil data berdasarkan merchant_id
        foreach ($data as $key) {
            // mengambil data berdasarkan merchant_id
            if ( $key['id'] == $id_merchant )
            {
                // get percentage
                $percentage = $this->show_percentage($key['user_id']);

                // get rating
                $rating = $this->show_rating($key['id']);

                // get gallery
                $gallery = $this->show_gallery($key['id']);

                $dataBersih[] = [
                    // encrypt id dengan panjang data 10 characters
                    'id'                => Crypt::encrypt($key['id']),
                    'user_id'           => Crypt::encrypt($key['user_id']),
                    'merchant_name'     => ucwords($key['merchant_name']),
                    'merchant_desc'     => ucfirst($key['merchant_desc']),
                    'merchant_address'  => $key['merchant_address'],
                    'open_hour'         => date('H:i', strtotime($key['open_hour'])),
                    'close_hour'        => date('H:i' ,strtotime($key['close_hour'])),
                    'phone_number'      => $key['phone_number'],
                    'latitude'          => $key['latitude'],
                    'longitude'         => $key['longitude'],
                    'email'             => $key['email'],
                    'jarak'             => strtoupper($jarak[$i]),
                    'percentage'        => $percentage,
                    'rating'            => $rating,
                    'gallery'           => $gallery,
                ];
                $i++;
            }
        }

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
