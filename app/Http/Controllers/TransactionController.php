<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Merchant;
use App\Models\MerchantGallery;
use App\Models\Review;
use App\Models\Transaction;
use App\Models\Booking;
use App\Models\GetAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;


class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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

            // dd($booking);

            if(!$merchant){
                return abort(404, 'Data Not Found!');
            }
            else {
                return view('customer.transaction.booking',[
                    'merchant' => $merchant,
                ]);
            }
        } catch (DecryptException $e) {
            $id_merchant = null;
            $e->getMessage();
            return abort(404, 'Data Not Found!');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'merchant_id'   => 'required',
            'device_id'     => 'required',
            'booking_date'  => 'required',
            'booking_time'  => 'required',
        ]);

        $merchant_id    = $request->merchant_id;
        $device_id      = $request->device_id;
        $booking_date   = date('Y-m-d', strtotime($request->booking_date));
        $booking_time   = $request->booking_time;

        $booking = Booking::create([
            'customer_id'   => auth()->user()->id,
            'merchant_id'   => $merchant_id,
            'device_id'     => $device_id,
            'booking_code'  => $this->create_booking_code(),
            'booking_date'  => $booking_date,
            'booking_time'  => $booking_time,
        ]);

        $transaction = Transaction::create([
            'booking_id'        => $booking->id,
            'user_id'           => auth()->user()->id,
            'merchant_id'       => $merchant_id,
            'no_transaction'    => 'TR'.date('YmdHis').mt_rand(100000, 999999),
            'status'            => 'BOOKED',
            'waranty'           => '0',
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Booking Success!',
            'data'    => $booking
        ], 201);
    }

    public function booking_success()
    {
        return view('confirmation.transaction-sucess');
    }


    public function list_time()
    {
        print_r("adaskdjadskjad");
        // $booking = $request->query('booking_date');
        // $merchant_id = $request->query('merchant_id');

        // print_r($booking, $merchant_id);


        // $booking_date = date('Y-m-d', strtotime($request->query('booking_date')));
        // $booking = Booking::where('merchant_id', $request->query('merchant_id'))
        //             ->where('booking_date', $input_date)
        //             ->get();

        // // data jam booking yang tersedia
        // $time           = $this->create_time_range($merchant->open_hour, $merchant->close_hour, '60 mins', '24');

        //  // jika ada waktu yg sudah di booking, maka hapus dari array time
        // if($booking){
        //     foreach($booking as $b){
        //         $key = array_search(date('H:i', strtotime($b->booking_time)), $time);
        //         if($key !== false){
        //             unset($time[$key]);
        //         }
        //     }
        // }

        // return response()->json([
        //     'success' => true,
        //     'message' => 'success',
        //     'data'    => $booking
        // ], 201);
    }


    public function create_time_range($start, $end, $interval = '60 mins', $format = '24')
    {
        $startTime = strtotime($start);
        $endTime   = strtotime($end);
        $returnTimeFormat = ($format == '24')?'H:i':'h:i A'; // formats: 24=00:00:00,

        $current   = time();
        $addTime   = strtotime('+'.$interval, $current);
        $diff      = $addTime - $current;

        $times     = array();
        while ($startTime < $endTime) {
            $times[] = date($returnTimeFormat, $startTime);
            $startTime += $diff;
        }
        $times[] = date($returnTimeFormat, $startTime);

        return $times;
    }

    public function create_booking_code()
    {
        $booking_code = 'BK'.date('YmdHis').mt_rand(100000, 999999);
        $check_booking_code = Booking::where('booking_code', $booking_code)->first();

        // check apakah booking code sudah ada
        if ($check_booking_code) {
            return $this->create_booking_code();
        } else {
            return $booking_code;
        }
    }

}
