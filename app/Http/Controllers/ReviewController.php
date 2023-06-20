<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Customer;
use App\Models\Merchant;
use App\Models\ReviewImage;
use App\Models\Review;
use App\Models\Notification;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Booking;
use App\Models\GetAPI;
use App\Models\Device;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addReview(Request $request)
    {
        $user_id        = auth()->user()->id;
        $review         = $request->review;
        $rating         = $request->rating;
        $no_transaction = $request->no_transaction;

        $transaction = Transaction::where('no_transaction', $no_transaction)->first();
        $merchant_id = Merchant::where('id', $transaction->merchant_id)->first();

        $review = Review::create([
            'transaction_id'    => $transaction->id,
            'user_id'           => $user_id,
            'merchant_id'       => $merchant_id->id,
            'review'            => $review,
            'rating'            => $rating,
        ]);

        $this->send_notification(
            $merchant_id->user_id,
            'New Review',
            'You have a new review'
        );

        if( $request->hasfile('photos') )
        {
            // multiple file upload
            $arr = [];

            foreach ($request->file('photos') as $file) {
                $fileName     = $file->getClientOriginalName();
                $file->move(public_path('assets/img/image_review/'.$no_transaction), $fileName);
                $arr[] = $fileName;
            }

            // insert data to database
            foreach ($arr as $key => $value) {
                $data = [
                    'review_id'     => $review->id,
                    'images'        => 'assets/img/image_review/'.$no_transaction.'/'.$value,
                ];

                $this->createReview($data);
            }
        }

        return response()->json([
            // 'review' => $review->id,
            'message' => 'Your review has been successfully submitted.'
        ], 201);
    }

    protected function createReview(array $data)
    {
        return ReviewImage::create([
            'review_id' => $data['review_id'],
            'image'     => $data['images'],
        ]);
    }


    public function send_notification($user_id, $title, $content)
    {
        $notification = Notification::create([
            'user_id'       => $user_id,
            'title'         => $title,
            'content'       => $content,
        ]);

        return response()->json($notification, 201);
    }

}
