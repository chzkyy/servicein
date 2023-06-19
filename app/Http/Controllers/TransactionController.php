<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Merchant;
use App\Models\MerchantGallery;
use App\Models\Review;
use App\Models\Notification;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Booking;
use App\Models\GetAPI;
use App\Models\Device;
use App\Mail\SendMail;
use Mail;
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
        ]);

        $dateNow            = date('d F Y');
        $username           = auth()->user()->username;
        $merchant           = Merchant::where('id', $merchant_id)->first();

        // print_r($merchant->user_id);
        // send notification to merchant
        $this->send_notification(
            $merchant->user_id,
            'New Transaction • '.$dateNow,
            'You have a new transaction with transaction ID : '.$transaction->no_transaction.' and booking code : '.$booking->booking_code.' from '.ucwords($username).' on '.$booking->booking_date.' at '.$booking->booking_time.' Please check your dashboard for more information.'
        );

        $this->send_notification(
            auth()->user()->id,
            'Transaction has been booked  • '.$dateNow,
            'Dear '.ucwords($username).' your transaction has successfully been made with transaction ID : '.$transaction->no_transaction.' and booking code : '.$booking->booking_code.' at '.ucwords($merchant->merchant_name).' on '.$booking->booking_date.' at '.$booking->booking_time.'.'
        );

        $this->send_notification_by_email(
            auth()->user()->id,
            'Transaction has been booked  • '.$dateNow,
            'Dear '.ucwords($username).' your transaction has successfully been made with transaction ID : '.$transaction->no_transaction.' and booking code : '.$booking->booking_code.' at '.ucwords($merchant->merchant_name).' on '.$booking->booking_date.' at '.$booking->booking_time.'.'
        );

        $this->send_notification_by_email(
            $merchant->user_id,
            'New Transaction • '.$dateNow,
            'You have a new transaction with transaction ID : '.$transaction->no_transaction.' and booking code : '.$booking->booking_code.' from '.ucwords($username).' on '.$booking->booking_date.' at '.$booking->booking_time.' Please check your dashboard for more information.'
        );

        return response ()->json ([
            'status'  => 'success',
            'message' => 'Booking Success',
        ], 200);
    }

    public function detail_transaction($id)
    {
        try {
            $transaction = Transaction::join('booking', 'booking.id', '=', 'transaction.booking_id')
                                        ->join('device', 'device.id', '=', 'booking.device_id')
                                        ->join('merchant', 'merchant.id', '=', 'booking.merchant_id')
                                        ->join('users', 'users.id', '=', 'merchant.user_id')
                                        ->join('customer', 'customer.user_id', '=', 'transaction.user_id')
                                        // where no_transaction = $id
                                        ->where('transaction.no_transaction', $id)
                                        ->orderBy('transaction.created_at', 'ASC')
                                        ->first();

            $review     = Review::where('transaction_id', $transaction->id)->first();

            // menghapus password dari array $transaction
            unset($transaction->password);

            if(!$transaction){
                return abort(404, 'Data Not Found!');
            }
            else {
                return view('customer.transaction.detail-transaction',[
                    'merchant_id' => crypt::encrypt($transaction->merchant_id),
                    'transaction' => $transaction,
                    'review'      => $review,
                ]);
            }
        } catch (DecryptException $e) {
            $id_transaction = null;
            $e->getMessage();
            return abort(404, 'Data Not Found!');
        }
    }

    public function show_transaction()
    {
        return view('customer.transaction.transaction-list');
    }

    public function cancle_booking(Request $request)
    {
        $no_transaction = $request->input('no_transaction');
        $transaction    = Transaction::where('no_transaction', $no_transaction)->first();

        Transaction::where('id', $transaction->id)->update([
            'status' => 'CANCELLED',
        ]);

        $dateNow            = date('d F Y');
        $username           = auth()->user()->username;
        $merchant           = Merchant::where('id', $transaction->merchant_id)->first();

        $data = [
            'merchant' => $merchant,
            'transaction' => $transaction
        ];

        // send notification to merchant
        $this->send_notification(
            $merchant->user_id,
            'Transaction has been cancelled • '.$dateNow,
            'Your transaction with transaction ID : '.$transaction->no_transaction.' and booking code : '.$transaction->booking->booking_code.' from '.ucwords($username).' on '.$transaction->booking->booking_date.' at '.$transaction->booking->booking_time.' has been cancelled. Please check your dashboard for more information.'
        );

        $this->send_notification(
            auth()->user()->id,
            'Transaction has been cancelled • '.$dateNow,
            'Dear '.ucwords($username).' your transaction with transaction ID : '.$transaction->no_transaction.' and booking code : '.$transaction->booking->booking_code.' at '.ucwords($merchant->merchant_name).' on '.$transaction->booking->booking_date.' at '.$transaction->booking->booking_time.' has been cancelled.'
        );

        $this->send_notification_by_email(
            auth()->user()->id,
            'Transaction has been cancelled • '.$dateNow,
            'Dear '.ucwords($username).' your transaction with transaction ID : '.$transaction->no_transaction.' and booking code : '.$transaction->booking->booking_code.' at '.ucwords($merchant->merchant_name).' on '.$transaction->booking->booking_date.' at '.$transaction->booking->booking_time.' has been cancelled.'
        );

        $this->send_notification_by_email(
            $merchant->user_id,
            'Transaction has been cancelled • '.$dateNow,
            'Your transaction with transaction ID : '.$transaction->no_transaction.' and booking code : '.$transaction->booking->booking_code.' from '.ucwords($username).' on '.$transaction->booking->booking_date.' at '.$transaction->booking->booking_time.' has been cancelled. Please check your dashboard for more information.'
        );

        return redirect()->route('show-transaction');
    }

    public function complaint(Request $request)
    {
        $no_transaction = $request->input('no_transaction');
        $transaction    = Transaction::where('no_transaction', $no_transaction)->first();
        $status      = 'ON COMPLAINT';

        Transaction::where('no_transaction', $no_transaction)->update([
            'status' => $status,
        ]);

        $dateNow            = date('d F Y');
        $username           = auth()->user()->username;
        $merchant           = Merchant::where('id', $transaction->merchant_id)->first();

        $data = [
            'merchant' => $merchant,
            'transaction' => $transaction
        ];

        // send notification to merchant
        $this->send_notification(
            $merchant->user_id,
            'Transaction has been on complaint • '.$dateNow,
            'Your transaction with transaction ID : '.$transaction->no_transaction.' and booking code : '.$transaction->booking->booking_code.' from '.ucwords($username).' on '.$transaction->booking->booking_date.' at '.$transaction->booking->booking_time.' has been on complaint. Please check your dashboard for more information.'
        );

        $this->send_notification(
            auth()->user()->id,
            'Transaction has been on complaint • '.$dateNow,
            'Dear '.ucwords($username).' your transaction with transaction ID : '.$transaction->no_transaction.' and booking code : '.$transaction->booking->booking_code.' at '.ucwords($merchant->merchant_name).' on '.$transaction->booking->booking_date.' at '.$transaction->booking->booking_time.' has been on complaint.'
        );

        $this->send_notification_by_email(
            auth()->user()->id,
            'Transaction has been on complaint • '.$dateNow,
            'Dear '.ucwords($username).' your transaction with transaction ID : '.$transaction->no_transaction.' and booking code : '.$transaction->booking->booking_code.' at '.ucwords($merchant->merchant_name).' on '.$transaction->booking->booking_date.' at '.$transaction->booking->booking_time.' has been on complaint.'
        );

        $this->send_notification_by_email(
            $merchant->user_id,
            'Transaction has been on complaint • '.$dateNow,
            'Your transaction with transaction ID : '.$transaction->no_transaction.' and booking code : '.$transaction->booking->booking_code.' from '.ucwords($username).' on '.$transaction->booking->booking_date.' at '.$transaction->booking->booking_time.' has been on complaint. Please check your dashboard for more information.'
        );

        return redirect()->route('home');
    }

    public function complaintDone(Request $request)
    {
        $no_transaction = $request->input('no_transaction');
        $status         = $request->input('status');


        Transaction::where('no_transaction', $no_transaction)->update([
                        'status' => $status,
                    ]);

        $customer = Transaction::where('no_transaction', $no_transaction)->first();
        $user     = User::where('id', $customer->user_id)->first();
        $dateNow  = date('d F Y');

        $this->send_notification(
            $customer->user_id,
            'Transaction has been completed • '.$dateNow,
            'Dear '.ucwords($user->username).', your transaction with transaction ID : '. $no_transaction.' has been completed. Please check your transaction list.',
        );

        $this->send_notification_by_email(
            $customer->user_id,
            'Transaction has been completed • '.$dateNow,
            'Dear '.ucwords($user->username).', your transaction with transaction ID : '. $no_transaction.' has been completed. Please check your transaction list.',
        );

        return response()->json([
            'status' => 200, // status code
            'message' => 'Success',
        ], 200);
    }




    /**
     *  function untuk admin merchant
     *
     *
     * @return \Illuminate\Http\Response
     */

    public function show_transaction_merchant()
    {
        $merchant = Merchant::where('user_id', auth()->user()->id)->first();

        $status_booked = Transaction::where('status', 'BOOKED')
                        ->where('merchant_id', $merchant->id)
                        ->count();
        $status_process = Transaction::where('status', 'ON PROGRESS')
                        ->orWhere('status', 'ON PROGRESS - Need Confirmation')
                        ->where('merchant_id', $merchant->id)
                        ->count();
        $status_done = Transaction::where('status', 'DONE')
                        ->where('merchant_id', $merchant->id)
                        ->count();
        $status_cancel = Transaction::where('status', 'CANCELLED')
                        ->where('merchant_id', $merchant->id)
                        ->count();

        return view('adminToko.Dashboard.index',[
            'status_booked'     => $status_booked,
            'status_process'    => $status_process,
            'status_done'       => $status_done,
            'status_cancel'     => $status_cancel,
            'title'             => 'Merchant - Dashboard',
        ]);
    }

    public function get_transaction_merchant(Request $request)
    {
        $user_id = auth()->user()->id;
        $merchant_id = Merchant::where('user_id', $user_id)->first();
        $status      = $request->query('status');

        $data        = [];

        if ( $status == 'ALL' )
        {
            $transaction = Transaction::join('booking', 'booking.id', '=', 'transaction.booking_id')
                                        ->join('device', 'device.id', '=', 'booking.device_id')
                                        ->join('merchant', 'merchant.id', '=', 'booking.merchant_id')
                                        ->join('customer', 'customer.user_id', '=', 'transaction.user_id')
                                        ->where('merchant.id', $merchant_id->id)
                                        ->orderBy('transaction.created_at', 'DESC')
                                        ->get();

        } elseif ( $status == 'ON PROGRESS' )
        {
            $transaction = Transaction::join('booking', 'booking.id', '=', 'transaction.booking_id')
                                        ->join('device', 'device.id', '=', 'booking.device_id')
                                        ->join('merchant', 'merchant.id', '=', 'booking.merchant_id')
                                        ->join('customer', 'customer.user_id', '=', 'transaction.user_id')
                                        ->where('merchant.id', $merchant_id->id)
                                        ->where('transaction.status', 'ON PROGRESS - Need Confirmation')
                                        ->orWhere('transaction.status', 'ON PROGRESS')
                                        ->orderBy('transaction.created_at', 'DESC')
                                        ->get();

        } else {
            $transaction = Transaction::join('booking', 'booking.id', '=', 'transaction.booking_id')
                                        ->join('device', 'device.id', '=', 'booking.device_id')
                                        ->join('merchant', 'merchant.id', '=', 'booking.merchant_id')
                                        ->join('customer', 'customer.user_id', '=', 'transaction.user_id')
                                        ->where('merchant.id', $merchant_id->id)
                                        ->where('transaction.status', $status)
                                        ->orderBy('transaction.created_at', 'DESC')
                                        ->get();
        }

        return response()->json($transaction, 200);
    }

    public function getTransactionDetailMerchant($id)
    {
        try {
             $transaction = Transaction::join('booking', 'booking.id', '=', 'transaction.booking_id')
                                        ->join('device', 'device.id', '=', 'booking.device_id')
                                        ->join('merchant', 'merchant.id', '=', 'booking.merchant_id')
                                        ->join('customer', 'customer.user_id', '=', 'transaction.user_id')
                                        ->where('transaction.no_transaction', $id)
                                        ->orderBy('transaction.created_at', 'ASC')
                                        ->first();

            $service_confirmation = Transaction::where('no_transaction', $id)
                                                ->first();

            if(!$transaction){
                return abort(404, 'Data Not Found!');
            }
            else {
                if($service_confirmation->status_confirmation == '0'){
                    $status_confirmation = 'Waiting Confirmation';
                } else if($service_confirmation->status_confirmation == 1){
                    $status_confirmation = 'Confirmed';
                } else if($service_confirmation->status_confirmation == 2){
                    $status_confirmation = 'Rejected';
                } else if ($service_confirmation->status_confirmation == null){
                    $status_confirmation = '-';
                }

                return view('adminToko.Transaksi.detail-transaksi',[
                    'transaction' => $transaction,
                    'status_confirmation' => $status_confirmation,
                ]);
            }
        } catch (DecryptException $e) {
            $id_transaction = null;
            $e->getMessage();
            return abort(404, 'Data Not Found!');
        }
    }

    public function updateStatus(Request $request)
    {
        $no_transaction = $request->input('no_transaction');
        $status         = $request->input('status');
        $merchant_note  = $request->input('merchant_note');

        if ($merchant_note != null)
        {
            Transaction::where('no_transaction', $no_transaction)->update([
                            'status'        => $status,
                            'merchant_note' => $merchant_note,
                        ]);
        }
        else
        {
            Transaction::where('no_transaction', $no_transaction)->update([
                            'status' => $status,
                        ]);
        }

        if( $status == 'DONE' ) {
            $customer = Transaction::where('no_transaction', $no_transaction)->first();
            $user     = User::where('id', $customer->user_id)->first();
            $dateNow  = date('d F Y');

            $this->send_notification(
                $customer->user_id,
                'Transaction has been completed • '.$dateNow,
                'Dear '.ucwords($user->username).', your transaction with transaction ID : '. $no_transaction.' has been completed. Please check your transaction list.',
            );

            $this->send_notification_by_email(
                $customer->user_id,
                'Transaction has been completed • '.$dateNow,
                'Dear '.ucwords($user->username).', your transaction with transaction ID : '. $no_transaction.' has been completed. Please check your transaction list.',
            );
        } elseif ( $status == 'CANCELLED' ) {
            $customer = Transaction::where('no_transaction', $no_transaction)->first();
            $user     = User::where('id', $customer->user_id)->first();
            $dateNow  = date('d F Y');

            $this->send_notification(
                $customer->user_id,
                'Transaction has been cancelled • '.$dateNow,
                'Dear '.ucwords($user->username).', your transaction with transaction ID : '. $no_transaction.' has been cancelled. Please check your transaction list.',
            );

            $this->send_notification_by_email(
                $customer->user_id,
                'Transaction has been cancelled • '.$dateNow,
                'Dear '.ucwords($user->username).', your transaction with transaction ID : '. $no_transaction.' has been cancelled. Please check your transaction list.',
            );
        }

        return response()->json([
            'status' => 200, // status code
            'message' => 'Success',
        ], 200);
    }

    public function send_confirm(Request $request)
    {
        $no_transaction         = $request->input('no_transaction');
        $service_confirmation   = $request->input('service_confirmation');
        $status                 = 'ON PROGRESS - Need Confirmation';

        $customer               = Customer::find($request->input('customer_id'));
        $user                   = User::find($customer->user_id);
        $status_confirmation     = '0'; // Waiting Confirmation

        Transaction::where('no_transaction', $no_transaction)->update([
                        'service_confirmation' => $service_confirmation,
                        'status_confirmation'  => $status_confirmation,
                        'status' => $status,
                    ]);

        $trs                    = Transaction::where('no_transaction', $no_transaction)->first();
        $merchant               = Merchant::find($trs->merchant_id);
        $dateNow                = date('d F Y');


        $this->send_notification(
            $customer->user_id,
            ucwords($merchant->merchant_name).' Sent a confirmation • '.$dateNow,
            'Dear '.ucwords($user->username).' you have pending confirmation on transaction ID : '. $no_transaction.'. Please check your transaction list.',
        );

        $this->send_notification_by_email(
            $customer->user_id,
            ucwords($merchant->merchant_name).' Sent a confirmation • '.$dateNow,
            'Dear '.ucwords($user->username).' you have pending confirmation on transaction ID : '. $no_transaction.'. Please check your transaction list.',
        );

        return response()->json([
            'status' => 200, // status code
            'message' => 'Success',
        ], 200);
    }


    public function getServiceConfirmation(Request $request)
    {
        $user_id = auth()->user()->id;
        $no_transaction = $request->input('no_transaction');

        $transaction = Transaction::join('booking', 'booking.id', '=', 'transaction.booking_id')
                                    ->join('device', 'device.id', '=', 'booking.device_id')
                                    ->join('merchant', 'merchant.id', '=', 'booking.merchant_id')
                                    ->join('customer', 'customer.user_id', '=', 'transaction.user_id')
                                    ->where('transaction.no_transaction', $no_transaction)
                                    ->first();

        // mengambil data merchant_id and encrypt merchant_id dari $transaction
        $merchant_id = Crypt::encrypt($transaction->merchant_id);
        $transaction->merchant_id = $merchant_id;


        return response()->json($transaction, 200);
    }

    public function sendServiceConfirmation(Request $request)
    {
        $no_transaction         = $request->input('no_transaction');
        $status_confirmation    = $request->input('status_confirmation');
        $status                 = 'ON PROGRESS';

        $customer               = Customer::find($request->input('customer_id'));
        $merchant_id            = Crypt::encrypt($request->input('merchant_id'));
        $user_id                = Merchant::find($merchant_id)->user_id;

        Transaction::where('no_transaction', $no_transaction)->update([
                        'status_confirmation' => $status_confirmation,
                        'status' => $status,
                    ]);

        $this->send_notification(
            $user_id,
            'Service Confirmation',
            'Your service has been confirmed by the customer, please check the servcice in your dashboard.'
        );

        return response()->json([
            'status' => 200, // status code
            'message' => 'Success',

        ], 200);
    }


    public function create_invoice($id)
    {
        $transaction = Transaction::join('booking', 'booking.id', '=', 'transaction.booking_id')
                                    ->join('device', 'device.id', '=', 'booking.device_id')
                                    ->join('customer', 'customer.user_id', '=', 'transaction.user_id')
                                    ->join('users', 'users.id', '=', 'transaction.user_id')
                                    ->where('transaction.no_transaction', $id)
                                    ->first();

        if ($transaction->status == 'DONE')
        {
            $merchant = Merchant::find($transaction->merchant_id);

            // menghilangka password
            unset($transaction->password);

            return view('adminToko.Transaksi.create-invoice',[
                'transaction' => $transaction,
                'merchant'    => $merchant,
            ]);
        }
        else
        {
            return abort(404, 'Data Not Found!');
        }

    }


    /**
     * function detail transaksi
     *
     */

    public function get_invoice(Request $request)
    {
        $no_transaction = $request->input('no_transaction');
        $transaction    = Transaction::where('no_transaction', $no_transaction)->first();

        $transaction_detail = TransactionDetail::where('transaction_id', $transaction->id)->get();

        return response()->json($transaction_detail, 200);
    }

    public function add_invoice(Request $request)
    {
        $no_transaction = $request->input('no_transaction');
        $transaction    = Transaction::where('no_transaction', $no_transaction)->first();

        $transaction_desc       = $request->input('transaction_desc');
        $transaction_price      = $request->input('transaction_price');

        TransactionDetail::create([
            'transaction_id'    => $transaction->id,
            'transaction_desc'  => $transaction_desc,
            'transaction_price' => $transaction_price,
        ]);

        return response()->json([
            'status' => 200, // status code
            'message' => 'Success',
        ], 200);
    }

    public function delete_invoice(Request $request)
    {
        $id = $request->input('id');
        TransactionDetail::where('id', $id)->delete();

        return response()->json([
            'status' => 200, // status code
            'message' => 'Success',
        ], 200);
    }

    public function update_invoice(Request $request)
    {
        $id                     = $request->input('id');
        $transaction_desc       = $request->input('transaction_desc');
        $transaction_price      = $request->input('transaction_price');

        TransactionDetail::where('id', $id)->update([
            'transaction_desc' => $transaction_desc,
            'transaction_price' => $transaction_price,
        ]);

        return response()->json([
            'status' => 200, // status code
            'message' => 'Success',
        ], 200);
    }

    public function sendInvoice(Request $request)
    {
        $no_transaction = $request->input('no_transaction');

        Transaction::where('no_transaction', $no_transaction)->update([
            'merchant_note' => $request->input('merchant_note'),
            'waranty'       => date('Y-m-d', strtotime($request->input('waranty'))),
        ]);

        return response()->json([
            'status' => 200, // status code
            'message' => 'Success',
        ], 200);
    }

    public function view_invoice($id)
    {
        $transaction = Transaction::join('booking', 'booking.id', '=', 'transaction.booking_id')
                                    ->join('device', 'device.id', '=', 'booking.device_id')
                                    ->join('customer', 'customer.user_id', '=', 'transaction.user_id')
                                    ->join('users', 'users.id', '=', 'transaction.user_id')
                                    ->where('transaction.no_transaction', $id)
                                    ->first();

        if ($transaction->status == 'DONE')
        {
            $merchant = Merchant::find($transaction->merchant_id);

            // menghilangka password
            unset($transaction->password);

            return view('adminToko.Transaksi.view-invoice',[
                'transaction' => $transaction,
                'merchant'    => $merchant,
            ]);
        }
        else
        {
            return abort(404, 'Data Not Found!');
        }

    }
    /**
     * view invoice for customer
     */
    public function view_invoice_customer($id)
    {
        $transaction        = Transaction::join('booking', 'booking.id', '=', 'transaction.booking_id')
                                    ->join('device', 'device.id', '=', 'booking.device_id')
                                    ->join('customer', 'customer.user_id', '=', 'transaction.user_id')
                                    ->join('users', 'users.id', '=', 'transaction.user_id')
                                    ->where('transaction.no_transaction', $id)
                                    ->first();
        $merchant           = Merchant::find($transaction->merchant_id);
        $trs                = Transaction::where('no_transaction', $id)->first();
        $transaction_detail = TransactionDetail::where('transaction_id', $trs->id)->get();

        $total              = $transaction_detail->sum('transaction_price');

        // menghilangka password
        unset($transaction->password);

        return view('customer.transaction.view-invoice',[
            'transaction'           => $transaction,
            'merchant'              => $merchant,
            'transaction_detail'    => $transaction_detail,
            'total'                 => $total,
        ]);

    }

    /**
     *  list Function untuk helper
     *
     *
     * @return \Illuminate\Http\Response
     */


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

    public function get_transaction(Request $request)
    {
        $user_id     = auth()->user()->id;
        $device      = Device::all();

        $status      = $request->query('status');

        $data        = [];
        // query transaction by status
        if($status != 'ALL'){
            $transaction = Transaction::join('booking', 'booking.id', '=', 'transaction.booking_id')
                            ->join('device', 'device.id', '=', 'booking.device_id')
                            ->join('merchant', 'merchant.id', '=', 'booking.merchant_id')
                            ->where('transaction.user_id', $user_id)
                            ->where('transaction.status', 'LIKE', '%'.$status.'%')
                            ->orderBy('transaction.created_at', 'DESC')
                            ->get();
        } elseif($status == 'ON PROGRESS') {
            $transaction = Transaction::join('booking', 'booking.id', '=', 'transaction.booking_id')
                            ->join('device', 'device.id', '=', 'booking.device_id')
                            ->join('merchant', 'merchant.id', '=', 'booking.merchant_id')
                            ->where('transaction.user_id', $user_id)
                            ->where('transaction.status', 'LIKE', '%'.$status.'%')
                            ->where('transaction.status', 'ON PROGRESS - Need Confirmation')
                            ->orderBy('transaction.created_at', 'DESC')
                            ->get();
        } else {
            $transaction = Transaction::join('booking', 'booking.id', '=', 'transaction.booking_id')
                            ->join('device', 'device.id', '=', 'booking.device_id')
                            ->join('merchant', 'merchant.id', '=', 'booking.merchant_id')
                            ->where('transaction.user_id', $user_id)
                            ->orderBy('transaction.created_at', 'DESC')
                            ->get();
        }

        foreach($transaction as $t){
            $data[] = [
                'id'                => $t->id,
                'merchant_id'       => Crypt::encrypt($t->merchant_id),
                'no_transaction'    => $t->no_transaction,
                'booking_code'      => $t->booking_code,
                'booking_date'      => $t->booking_date,
                'booking_time'      => $t->booking_time,
                'device_name'       => $t->device_name,
                'merchant_name'     => $t->merchant_name,
                'status'            => $t->status,
                'created_at'        => $t->created_at,
            ];
        }

        // json obj to array
        // $transaction = json_decode($transaction, true);
        return response()->json($data, 200);
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

    public function send_notification_by_email($user_id, $title, $content)
    {
        $user = User::find($user_id);
        $email = $user->email;

        $maildata = [
            'to'        => $email,
            'subject'   => $title,
            'body'      => $content,
        ];

        Mail::to($email)->send(new SendMail($maildata));

        return response()->json(null, 201);
    }
}
