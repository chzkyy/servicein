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

    public function booking_success()
    {
        return view('confirmation.transaction-sucess');
    }

    public function store(Request $request)
    {
        $request->validate([
            'merchant_id'   => 'required',
            'device_id'     => 'required',
            'booking_date'  => 'required',
            'booking_time'  => 'required',
            'user_note'     => 'string|max:255|nullable',
        ]);

        $merchant_id    = $request->merchant_id;
        $device_id      = $request->device_id;
        $booking_date   = date('Y-m-d', strtotime($request->booking_date));
        $booking_time   = $request->booking_time;
        $user_note      = $request->user_note;

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
            'user_note'         => $user_note,
            'waranty'           => '0',
        ]);


        return response()->json([
            'status'  => 'success',
            'message' => 'Booking Success!',
            'data'    => $booking
        ], 201);
    }

    public function list_time(Request $request)
    {

        $booking_date = $request->input('booking_date');
        $merchant_id  = $request->input('merchant_id');
        $merchant     = Merchant::find($merchant_id);

        // join table booking table dan transaction table and get time booking information

        $transaction = Transaction::join('booking', 'booking.id', '=', 'transaction.booking_id')
                        ->where('booking.booking_date', $booking_date)
                        ->where('booking.merchant_id', $merchant_id)
                        ->where('transaction.status', 'BOOKED')
                        ->get();
        $time         = $this->create_time_range($merchant->open_hour, $merchant->close_hour, '60 mins', '24');




        // data jam booking yang tersedia
        if( $transaction->count() > 0 ){
            foreach($transaction as $t){
                $key = array_search(date('H:i', strtotime($t->booking_time)), $time);
                if($key !== false){
                    // jika ada yg sudah di booking, maka hapus dari array time;
                    unset($time[$key]);
                    // mengeluarkan hasil akhir time
                    $time = array_values($time);
                }
            }
        }

        return response()->json($time, 201);
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


    /**
     * Display Transaction List.
     *
     * @param  \App\Models\Transaction  $transaction
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */

    public function show_transaction()
    {
        $user_id     = auth()->user()->id;
        $transaction = Transaction::join('booking', 'booking.id', '=', 'transaction.booking_id')
                        ->join('merchant', 'merchant.id', '=', 'booking.merchant_id')
                        ->where('transaction.user_id', $user_id)
                        ->get();

        // return view('transaction.transaction', [
        //     'transaction' => $transaction,
        // ]);
        // return json pretty_print($transaction);
        // $trs = json_encode($transaction, JSON_PRETTY_PRINT);
        return response()->json($transaction, 200);
    }

}
