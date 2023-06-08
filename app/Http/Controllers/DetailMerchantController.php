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


class DetailMerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        try {
            $id_merchant    = Crypt::decryptString($id);
            $merchant       = Merchant::find($id_merchant);
            $review         = Review::where('merchant_id', $id_merchant)->first();
            $gallery        = $this->show_gallery($id_merchant);
            $dataReview     = [];

            if(!$merchant){
                return abort(404, 'Data Not Found!');
            }
            else {
                if($review == null) {
                    $dataReview = null;
                }
                else {
                    $review = Review::where('merchant_id', $id_merchant)->get();
                    foreach ($review as $item) {
                        $username = User::where('id', $review->user_id)->first();
                        
                        $dataReview[] = [
                            'id'        => $item['id'],
                            'name'      => $username->username,
                            'rating'    => $item['rating'],
                            'review'    => $item['review'],
                            'date'      => $item['created_at'],
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

}