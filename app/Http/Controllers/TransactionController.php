<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Merchant;
use App\Models\MerchantGallery;
use App\Models\Review;
use App\Models\Notification;
use App\Models\Transaction;
use App\Models\Booking;
use App\Models\GetAPI;
use App\Models\Device;
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

        $merchant_id        = $request->merchant_id;
        $device_id          = $request->device_id;
        $booking_date       = date('Y-m-d', strtotime($request->booking_date));
        $booking_time       = $request->booking_time;
        $user_note          = $request->user_note;

        $booking_code       = $this->create_booking_code();
        $transaction_code   = $this->create_transaction_code();


        $booking = Booking::create([
            'customer_id'   => auth()->user()->id,
            'merchant_id'   => $merchant_id,
            'device_id'     => $device_id,
            'booking_code'  => $booking_code,
            'booking_date'  => $booking_date,
            'booking_time'  => $booking_time,
        ]);

        $transaction = Transaction::create([
            'booking_id'        => $booking->id,
            'user_id'           => auth()->user()->id,
            'merchant_id'       => $merchant_id,
            'no_transaction'    => $transaction_code,
            'status'            => 'BOOKED',
            'user_note'         => $user_note,
            'waranty'           => '0',
        ]);

        $dateNow            = date('d F Y');
        $username           = auth()->user()->username;
        $merchant           = Merchant::where('id', $merchant_id)->first();

        // print_r($merchant->user_id);
        // send notification to merchant
        $this->send_notification(
            $merchant->user_id,
            'New Transaction • '.$dateNow,
            'You have a new transaction with transaction ID : '.$transaction->no_transaction.' and booking code : '.$booking->booking_code.' from '.$username.' on '.$booking->booking_date.' at '.$booking->booking_time.'Please check your transaction list for more information.'
        );

        $this->send_notification(
            auth()->user()->id,
            'Transaction has been booked  • '.$dateNow,
            'Dear '.$username.' your transaction has successfully been made with transaction ID : '.$transaction->no_transaction.' and booking code : '.$booking->booking_code.' at '.$merchant->merchant_name.' on '.$booking->booking_date.' at '.$booking->booking_time.'.'
        );

        return response ()->json ([
            'status'  => 'success',
            'message' => 'Booking Success',
        ], 200);
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
        if($check_booking_code){
            $this->create_booking_code();
        }
        else {
            return $booking_code;
        }
    }

    public function create_transaction_code()
    {
        $transaction_code = 'TR'.date('YmdHis').mt_rand(100000, 999999);
        $check_transaction_code = Transaction::where('no_transaction', $transaction_code)->first();
        if($check_transaction_code){
            $this->create_transaction_code();
        }
        else {
            return $transaction_code;
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
        return view('customer.transaction.transaction-list');
    }

    public function get_transaction(Request $request)
    {
        $user_id     = auth()->user()->id;
        $device      = Device::all();

        $status      = $request->query('status');

        // query transaction by status
        if($status != 'ALL'){
            $transaction = Transaction::join('booking', 'booking.id', '=', 'transaction.booking_id')
                            ->join('device', 'device.id', '=', 'booking.device_id')
                            ->join('merchant', 'merchant.id', '=', 'booking.merchant_id')
                            ->where('transaction.user_id', $user_id)
                            ->where('transaction.status', 'LIKE', '%'.$status.'%')
                            ->orderBy('transaction.created_at', 'ASC')
                            ->get();
        } else {
            $transaction = Transaction::join('booking', 'booking.id', '=', 'transaction.booking_id')
                            ->join('device', 'device.id', '=', 'booking.device_id')
                            ->join('merchant', 'merchant.id', '=', 'booking.merchant_id')
                            ->where('transaction.user_id', $user_id)
                            ->orderBy('transaction.created_at', 'ASC')
                            ->get();
        }


        // json obj to array
        // $transaction = json_decode($transaction, true);
        return response()->json($transaction, 200);
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
