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
        $data_merchant = Merchant::join('transaction', 'transaction.merchant_id', '=', 'merchant.id')
                                ->join('users', 'users.id', '=', 'merchant.user_id')
                                ->select('merchant.*', 'transaction.*', 'users.status_account')
                                ->get();

        $input_month = $request->query('month');
        //mengabungkan data merchant dan transaksi
        $data = [];
        foreach ($data_merchant as $key => $value) {
            $bills = $this->show_bill($value->merchant_id);


            if ( $bills != null )
            {
                // $bills->bills_date = 062023 jadi 06
                $month  = substr($bills->bills_date, 0, 2);
                $status = $bills->status;
            }
            else {
                $month  = '-';
                $status = '-';
            }



            if ( $value->status == 'DONE'  && $value->status_account == 'active' )
            {
                $data[$key]['id']           = $value->id;
                $data[$key]['merchant_id']  = Crypt::encrypt($value->merchant_id);
                $data[$key]['name']         = $value->merchant_name;
                $data[$key]['phone_number'] = $value->phone_number;
                $data[$key]['address']      = $value->address;
                $data[$key]['description']  = $value->description;
                $data[$key]['rating']       = $this->show_rating($value->merchant_id);
                $data[$key]['transaction']  = $this->show_transaction($value->merchant_id);
                $data[$key]['month_bill']   = $month;
                $data[$key]['status']       = $status;
                $data[$key]['status_account'] = $value->status_account;
                $data[$key]['created_at']   = $value->created_at;
                $data[$key]['updated_at']   = $value->updated_at;
            }
        }

        $data = $this->unique_multidim_array($data,'name');

        if ( $input_month != 'ALL' )
        {
            // search $data berdasarkan month_bill
            $data = array_filter($data, function ($var) use ($input_month) {
                return ($var['month_bill'] == $input_month);
            });

            return response()->json($data, 200);
        }

        return response()->json($data, 200);
    }


    public function activateAccount($id)
    {
        $id      = Crypt::decrypt($id);
        $user_id = Merchant::where('id', $id)
                    ->first()
                    ->user_id;

        $data    = User::where('id', $user_id)
                        ->update([
                            'status_account' => 'active',
                        ]);

        return response()->json($data, 200);
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

        return response()->json($data, 200);
    }

    public function viewBIll($id)
    {
        $id               = Crypt::decrypt($id);
        $user_id          = Merchant::where('id', $id)
                                ->first()
                                ->user_id;
        $merchant         = Merchant::join('users', 'users.id', '=', 'merchant.user_id')
                                ->where('merchant.id', $id)
                                ->select('merchant.*', 'users.email')
                                ->get();

        $data      = [];
        // bill = 1 bulan sebelumnya denga format 052023
        $prevmonth = strtotime("-1 month");
        $bill_date = date("F Y", $prevmonth);

        $merchant_bill              = $this->show_bill($id);

        if( $merchant_bill['proof_of_payment'] == NULL )
        {
            $merchant_bill['proof_of_payment'] = '/assets/img/no-image.jpg';
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
            $data['proof_of_payment']   = $merchant_bill['proof_of_payment'];
        }

        return view('adminApps.view-bill', [
            'merchant' => $data
        ]);
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
        $data               = MerchantBill::where('merchant_id', $merchant_id)
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
        $data               = MerchantBill::where('merchant_id', $merchant_id)
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
        $user_id = auth()->user()->id;
        $email   = auth()->user()->email;
        $merchant = Merchant::where('user_id', $user_id)->first();

        $data     = MerchantBill::where('merchant_id', $merchant->id)->get();
        $total_transaction    = $this->show_transaction($merchant->id);

        foreach( $data as $key => $value ) {
            $month  = substr($value->bills_date, 0, 2);
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

}
