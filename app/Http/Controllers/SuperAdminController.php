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
                                ->select('merchant.*', 'transaction.*')
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



            if ( $value->status == 'DONE' )
            {
                $data[$key]['id']           = $value->id;
                $data[$key]['merchant_id']  = Crypt::encryptString($value->merchant_id);
                $data[$key]['name']         = $value->merchant_name;
                $data[$key]['phone_number'] = $value->phone_number;
                $data[$key]['address']      = $value->address;
                $data[$key]['description']  = $value->description;
                $data[$key]['rating']       = $this->show_rating($value->merchant_id);
                $data[$key]['transaction']  = $this->show_transaction($value->merchant_id);
                $data[$key]['month_bill']   = $month;
                $data[$key]['status']       = $status;
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
                        ->first();

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
        $data = MerchantBill::create([
            'merchant_id'   => $request->merchant_id,
            'no_bill'       => $request->no_bill,
            'amount'        => $request->amount,
            'bills_date'    => $request->bills_date,
            'status'        => 'UNPAID',
        ]);

        return response()->json([
            'status'    => 'success',
            'message'   => 'Bill has been created',
        ], 200);
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

}
