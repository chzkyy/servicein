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
use App\Models\MerchantBill;
use App\Models\Device;
use App\Mail\SendMail;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class SuperAdminController extends Controller
{
    public function index()
    {
        return view('adminApps.index');
    }

    public function getDataMerchant(Request $request)
    {
        $data_merchant = Merchant::join('users', 'users.id', '=', 'merchant.user_id')
                                ->select('merchant.*', 'users.status_account', 'users.email')
                                ->get();

        $data = [];
        foreach ($data_merchant as $key => $value) {

            $data[$key]['id']           = $value->id;
            // $data[$key]['merchant_id']  = $value->merchant_id;
            $data[$key]['merchant_id']  = Crypt::encrypt($value->id);
            $data[$key]['name']         = $value->merchant_name;
            $data[$key]['phone_number'] = $value->phone_number;
            $data[$key]['email']        = $value->email;
            $data[$key]['rating']       = $this->show_rating($value->id);
            $data[$key]['status_account'] = $value->status_account;
            $data[$key]['created_at']   = $value->created_at;
            $data[$key]['updated_at']   = $value->updated_at;
        }

        $data = $this->unique_multidim_array($data,'name');

        return response()->json($data, 200);
    }

    public function viewCreateBill($id)
    {
        return view('adminApps.create-bill', [
            'id' => $id
        ]);
    }

    public function listBill(Request $request)
    {
        $input      = $request->input('id');
        $id         = Crypt::decrypt($input);
        $viewBill   = MerchantBill::where('merchant_id', $id)
                        ->get();

        $jumlah_quantity  = Transaction::where('merchant_id', $id)
                        ->where('status', 'DONE')
                        ->whereMonth('created_at', '=', date('m', strtotime('-1 month')))
                        ->count();

        $data = [];
        foreach ($viewBill as $key => $value) {

            // $bill_date =
            $month  = substr($value->bills_date, 0, 2);
            $year   = substr($value->bills_date, 2, 4);
            $bill_date = date("F Y", strtotime($year.'-'.$month.'-01'));

            $data[$key]['id']           = $value->id;
            $data[$key]['no_bill']      = $value->no_bill;
            $data[$key]['merchant_id']  = Crypt::encrypt($value->merchant_id);
            $data[$key]['bill_date']    = $bill_date;
            $data[$key]['quantity']     = $jumlah_quantity;
            $data[$key]['status']       = $value->status;
            $data[$key]['created_at']   = $value->created_at;
            $data[$key]['updated_at']   = $value->updated_at;
        }

        return response( $data, 200 );
    }


    public function activateAccount(Request $request)
    {
        $input   = $request->input('id');
        $id      = Crypt::decrypt($input);
        $user_id = Merchant::where('id', $id)
                    ->first()
                    ->user_id;

        $data    = User::where('id', $user_id)
                    ->update([
                        'status_account' => 'active',
                    ]);

        $this->send_notification_by_email($user_id, 'Activate Account', 'Your account has been activated by admin');

        return response()->json($id, 200);
    }

    public function suspendAccount(Request $request)
    {
        $input   = $request->input('id');
        $id      = Crypt::decrypt($input);
        $user_id = Merchant::where('id', $id)
                    ->first()
                    ->user_id;

        $data    = User::where('id', $user_id)
                    ->update([
                        'status_account' => 'suspended',
                    ]);

        $this->send_notification_by_email($user_id, 'Suspend Account', 'Your account has been suspended by admin');

        return response()->json($data, 200);
    }

    public function viewBIll($id)
    {
        $merchant_id      = MerchantBill::where('no_bill', $id)
                                ->first()
                                ->merchant_id;

        $merchant         = Merchant::join('users', 'users.id', '=', 'merchant.user_id')
                                ->where('merchant.id', $merchant_id)
                                ->select('merchant.*', 'users.email')
                                ->get();

        $data      = [];

        $merchant_bill = MerchantBill::where('no_bill', $id)
                                ->first();

        $month  = substr($merchant_bill['bills_date'], 0, 2);
        $year   = substr($merchant_bill['bills_date'], 2, 4);
        $bill_date = date("F Y", strtotime($year.'-'.$month.'-01'));

        if( $merchant_bill['proof_of_payment'] == null )
        {
            $merchant_bill['proof_of_payment'] = 'assets/img/no-image.jpg';
        }

        foreach( $merchant as $value )
        {
            $data['id']                 = $value->id;
            $data['merchant_id']        = Crypt::encrypt($value->id);
            $data['merchant_name']      = $value->merchant_name;
            $data['merchant_desc']      = $value->merchant_desc;
            $data['email']              = $value->email;
            $data['status']             = $merchant_bill['status'];
            $data['bill_date']          = $bill_date;
            $data['no_bill']            = $merchant_bill['no_bill'];
            $data['proof_of_payment']   = $merchant_bill['proof_of_payment'];

        }

        return view('adminApps.view-bill', [
            'merchant' => $data
        ]);

        // return response()->json($data,   200);
    }

    public function sendBIll($id)
    {
        $id               = Crypt::decrypt($id);
        $user_id          = Merchant::where('id', $id)
                                ->first()
                                ->user_id;
        $merchant         = Merchant::join('users', 'users.id', '=', 'merchant.user_id')
                                ->where('merchant.id', $id)
                                ->select('merchant.*', 'users.email')
                                ->get();
        $jumlah_quantity  = Transaction::where('merchant_id', $id)
                                ->where('status', 'DONE')
                                ->whereMonth('created_at', '=', date('m', strtotime('-1 month')))
                                ->count();

        $data      = [];
        // bill = 1 bulan sebelumnya denga format 052023
        $prevmonth = strtotime("-1 month");
        $bill_date = date("F Y", $prevmonth);

        // bills date for insert to database
        $tagihan_bulan = date('mY', $prevmonth);


        foreach( $merchant as $value )
        {
            $data['id']             = $value->id;
            $data['merchant_id']    = Crypt::encrypt($value->id);
            $data['merchant_name']  = $value->merchant_name;
            $data['merchant_desc']  = $value->merchant_desc;
            $data['total']          = $jumlah_quantity;
            $data['email']          = $value->email;
            $data['bill_date']      = $bill_date;
            $data['bills']          = $tagihan_bulan;
        }

        return view('adminApps.send-bill', [
            'merchant' => $data
        ]);
    }

    public function getListTransaction(Request $request)
    {
        $merchant_id      = $request->input('merchant_id');
        $merchant_id      = Crypt::decrypt($merchant_id);
        $data_transaction = Transaction::where('merchant_id', $merchant_id)
                            ->where('status', 'DONE')
                            ->whereMonth('created_at', '=', date('m', strtotime('-1 month')))
                            ->get();

        $dataBersih = [];
        // membuat total transaksi
        foreach ($data_transaction as $key => $value) {
            $dataBersih[$key]['id']             = $value->id;
            $dataBersih[$key]['merchant_id']    = $value->merchant_id;
            $dataBersih[$key]['status']         = $value->status;
            $dataBersih[$key]['no_transaction'] = $value->no_transaction;
            $dataBersih[$key]['created_at']     = ($value->created_at)->format('d F Y');
            $dataBersih[$key]['updated_at']     = $value->updated_at;
        }

        // sort by date
        usort($dataBersih, function($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });

        return response()->json($dataBersih, 200);
    }

    public function deleteAccount(Request $request)
    {
        $input          = $request->input('id');
        $id             = Crypt::decrypt($input);
        $user_id        = Merchant::where('id', $id)
                            ->first()
                            ->user_id;

        // soft delete user
        $data           = User::where('id', $user_id)
                            ->delete();
        $deleteMerchant = Merchant::where('id', $id)
                            ->delete();

        $this->send_notification_by_email($user_id, 'Delete Account', 'Your account has been deleted by admin');

        return response()->json([
            'status'    => 'success',
            'message'   => 'Success delete account',
        ], 200);
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

    public function show_transaction($id)
    {
        // menghitung jumlah transaksi yang statusnya DONE
        $transaction = Transaction::where('merchant_id', $id)
                        ->where('status', 'DONE')
                        ->count();
                        // ->first();

        return $transaction;
    }

    public function show_bill($id)
    {
        $data = MerchantBill::where('merchant_id', $id)
                        ->get();

        // show data terakhir
        $data = $data->last();

        return $data;
    }

    // membuat filter bill berdasarkan bulan dan tahun
    public function filter_bill(Request $request)
    {
        $data = MerchantBill::where('bills_date', 'LIKE', "%{$request->month}%")
                        ->get();
        return response()->json($data, 200);
    }

    public function update_bill($id, Request $request)
    {
        $data = MerchantBill::where('id', $id)
                    ->update([
                        'status'        => $request->status,
                        'reason'        => $request->reason,
                        'approved_by'   => $request->approved_by,
                        'rejected_by'   => $request->rejected_by,
                    ]);

        return response()->json($data, 200);
    }

    public function createBill(Request $request)
    {

        $merchant_id        = Crypt::decrypt($request->input('merchant_id'));
        $jmlh_transaksi     = $request->input('jmlh_transaksi');
        $amount             = $jmlh_transaksi * 5000;

        $data = MerchantBill::create([
            'merchant_id'   => $merchant_id,
            'no_bill'       => $this->create_no_bill(),
            'amount'        => $amount,
            'bills_date'    => $request->input('bills_date'),
            'status'        => 'UNPAID',
        ]);

        return response()->json([
            'status'    => 'success',
            'message'   => 'Bill has been created',
        ], 200);
    }

    public function approved(Request $request)
    {
        $merchant_id        = Crypt::decrypt($request->input('merchant_id'));
        $no_bill            = $request->input('no_bill');
        $data               = MerchantBill::where('no_bill', $no_bill)
                                ->update([
                                    'status'        => 'APPROVED',
                                    'reason'        => $request->input('reason'),
                                    'approved_by'   => $request->input('approved_by'),
                                ]);

        return response()->json($data, 200);
    }

    public function decline(Request $request)
    {
        $merchant_id        = Crypt::decrypt($request->input('merchant_id'));
        $no_bill            = $request->input('no_bill');
        $data               = MerchantBill::where('no_bill', $no_bill)
                                ->update([
                                    'status'        => 'DECLINE',
                                    'reason'        => $request->input('reason'),
                                    'rejected_by'   => $request->input('rejected_by'),
                                ]);

        return response()->json($data, 200);
    }

    /**
     *  Function to merchant get bill information
     *
     *
     * @param $array
     * @param $key
     * @return array
     */

    public function viewMerchant()
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

        return view('adminToko.Dashboard.bills',[
            'title'             => 'Merchant - Bills',
            'status_booked'     => $status_booked,
            'status_process'    => $status_process,
            'status_done'       => $status_done,
            'status_cancel'     => $status_cancel,
        ]);

    }

    public function getListBillsMerchant()
    {
        $user_id    = auth()->user()->id;
        $email      = auth()->user()->email;
        $merchant   = Merchant::where('user_id', $user_id)->first();
        $data       = MerchantBill::where('merchant_id', $merchant->id)->get();


        foreach( $data as $key => $value ) {
            $month                              = substr($value->bills_date, 0, 2);
            $total_transaction                  = Transaction::where('merchant_id', $merchant->id)
                                                    ->where('status', 'DONE')
                                                    ->where('created_at', 'LIKE', "%{$month}%")
                                                    ->count();
            $data[$key]['no_bill']              = $value->no_bill;
            $data[$key]['bills_date']           = $month;
            $data[$key]['total_transaction']    = $total_transaction;
            $data[$key]['amount']               = $value->amount;
            $data[$key]['status']               = $value->status;
            $data[$key]['email']                = $email;
            $data[$key]['phone_number']         = $merchant->phone_number;
        }

        return response()->json($data, 200);
    }

    public function viewBillsMerchant($id)
    {
        $merchant_id      = MerchantBill::where('no_bill', $id)
                                ->first()
                                ->merchant_id;

        $merchant         = Merchant::join('users', 'users.id', '=', 'merchant.user_id')
                                ->where('merchant.id', $merchant_id)
                                ->select('merchant.*', 'users.email')
                                ->get();

        $data      = [];

        $merchant_bill = MerchantBill::where('no_bill', $id)
                                ->first();

        $month  = substr($merchant_bill['bills_date'], 0, 2);
        $year   = substr($merchant_bill['bills_date'], 2, 4);
        $bill_date = date("F Y", strtotime($year.'-'.$month.'-01'));
        $m      = date("m", strtotime($year.'-'.$month.'-01'));

        if( $merchant_bill['proof_of_payment'] == null )
        {
            $merchant_bill['proof_of_payment'] = 'assets/img/no-image.jpg';
        }

        $total_transaction    = $this->show_transaction($merchant_id);

        foreach( $merchant as $value )
        {
            $total_transaction          = Transaction::where('merchant_id', $merchant_id)
                                                ->where('status', 'DONE')
                                                ->where('created_at', 'LIKE', "%{$month}%")
                                                ->count();


            $data['id']                 = $value->id;
            $data['merchant_id']        = Crypt::encrypt($value->id);
            $data['merchant_name']      = $value->merchant_name;
            $data['merchant_desc']      = $value->merchant_desc;
            $data['email']              = $value->email;
            $data['total_transaction']  = $total_transaction;
            $data['amount']             = $merchant_bill['amount'];
            $data['status']             = $merchant_bill['status'];
            $data['bill_date']          = $bill_date;
            $data['month']              = $m;
            $data['bill_no']            = $id;
            $data['proof_of_payment']   = $merchant_bill['proof_of_payment'];

        }

        return view('adminToko.Bills.viewBills', [
            'merchant' => $data
        ]);
    }

    public function getListTransactionBills(Request $request)
    {
        $merchant_id      = $request->input('merchant_id');
        $merchant_id      = Crypt::decrypt($merchant_id);
        $month            = $request->input('month');



        $data_transaction = Transaction::where('merchant_id', $merchant_id)
                            ->where('status', 'DONE')
                            ->whereMonth('created_at', '=', date('m', strtotime('-1 month')))
                            // ->where('created_at', 'LIKE', "%{$month}%")
                            ->get();

        $dataBersih = [];
        // membuat total transaksi
        foreach ($data_transaction as $key => $value) {
            $dataBersih[$key]['id']             = $value->id;
            $dataBersih[$key]['merchant_id']    = $value->merchant_id;
            $dataBersih[$key]['status']         = $value->status;
            $dataBersih[$key]['no_transaction'] = $value->no_transaction;
            $dataBersih[$key]['created_at']     = ($value->created_at)->format('d F Y');
            $dataBersih[$key]['updated_at']     = $value->updated_at;
        }

        // sort by date
        usort($dataBersih, function($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });

        return response()->json($dataBersih, 200);
    }

    public function sendproof(Request $request)
    {
        $file           = $request->file('file');
        $bill_no        = $request->input('bill_no');

        $merchant_id    = MerchantBill::where('no_bill', $bill_no)
                            ->first()
                            ->merchant_id;

        $date          = MerchantBill::where('no_bill', $bill_no)
                            ->first()
                            ->bills_date;

        // save file
        $file_name = $merchant_id.'-'.$bill_no.'.'.$file->getClientOriginalExtension();
        $file->move('assets/img/bills/'.$merchant_id.'/'.$date, $file_name);

        // update data
        $update = MerchantBill::where('no_bill', $bill_no)
                    ->update([
                        'proof_of_payment'  => 'assets/img/bills/'.$merchant_id.'/'.$date.'/'.$file_name,
                        'status'            => 'PAID'
                    ]);

        if($update)
        {
            return response()->json([
                'status'    => 'success',
                'message'   => 'Success upload proof of payment'
            ], 200);
        }
        else
        {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Failed upload proof of payment'
            ], 200);
        }
    }

    function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();
        foreach( $array as $val ) {
            if ( ! in_array( $val[$key], $key_array ) ) {
                $key_array[$i] = $val[$key];
                $temp_array[] = $val; // <--- remove the $i
            }
            $i++;
        }
        return $temp_array;
    }

    public function create_no_bill()
    {
        $bill_no = 'BILL'.date('YmdHis').mt_rand(100000, 999999);
        $check_bill_no = MerchantBill::where('no_bill', $bill_no)->first();
        if($check_bill_no){
            $this->create_booking_code();
        }
        else {
            return $bill_no;
        }
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
