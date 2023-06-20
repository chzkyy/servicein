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
use App\Models\Chat;
use App\Mail\SendMail;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ChatController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application chat.
     *
     * For Customer
     */
    public function viewChatCust($merchant_id)
    {
        $merchant_id = Crypt::decrypt($merchant_id);
        $merchant    = Merchant::where('id', $merchant_id)->first();
        $profileChat = User::where('id', $merchant->user_id)->first();
        // return $merchant;
        $avatar     = $profileChat->avatar;

        if($avatar == null) {
            $avatar = 'assets/img/profile_picture.png';
        }

        return view('chat.room-cust',[
            'merchant_id' => Crypt::encrypt($merchant_id),
            'avatar'      => $avatar,
            'name'        => $merchant->merchant_name,
        ]);
    }

    public function getMessageCust(Request $request)
    {
        $merchant_id = Crypt::decrypt($request->input('merchant_id'));
        $user         = auth()->user()->id;
        $merchant     = Merchant::where('id', $merchant_id)->first();
        $chat         = Chat::where('from', $user)->where('to', $merchant->user_id)->get(); // chat dari customer ke merchant
        $chat2        = Chat::where('from', $merchant->user_id)->where('to', $user)->get(); // chat dari merchant ke customer

        $dataMessage = [];
        $dataMerchant = [];
        $dataCustomer = [];

        foreach ($chat as $key => $value) {
            $dataCustomer[] = [
                'id'            => $value->id,
                'from'          => $value->from,
                'to'            => $value->to,
                'message'       => $value->message,
                'attachment'    => $value->attachment,
                'status'        => $value->status,
                'created_at'    => $value->created_at,
            ];
        }

        foreach ($chat2 as $key => $value) {
            $dataMerchant[] = [
                'id'            => $value->id,
                'from'          => $value->from,
                'to'            => $value->to,
                'message'       => $value->message,
                'attachment'    => $value->attachment,
                'status'        => $value->status,
                'created_at'    => $value->created_at,
            ];
        }

        $dataMessage = array_merge($dataCustomer, $dataMerchant);

        // sort by created_at
        usort($dataMessage, function ($a, $b) {
            return $a['created_at'] <=> $b['created_at'];
        });

        return response()->json($dataMessage, 200);
    }

    public function listChatCust()
    {
        return view('chat.chat-customer');
    }

    public function getlistCust()
    {
        $customer = auth()->user()->id;
        $chat     = Chat::where('to', $customer)->get();
        $list_message_from= [];

        foreach ($chat as $key => $value) {
            $user = User::where('id', $value->from)->first();
            $merchant = Merchant::where('user_id', $value->from)->first();

            if($user->avatar == null) {
                $user->avatar = 'assets/img/profile_picture.png';
            }

            if ($value->status == 0) {
                $value->status = 'Unread';
            } else {
                $value->status = 'Read';
            }

            $time = date("H:i", strtotime($value->created_at));

            $list_message_from[] = [
                'id'            => $value->id,
                'from'          => $value->from,
                'to'            => $value->to,
                'message'       => $value->message,
                'attachment'    => $value->attachment,
                'status'        => $value->status,
                'created_at'    => $value->created_at,
                'time'          => $time,
                'merchant_id'   => Crypt::encrypt($merchant->id),
                'avatar'        => $user->avatar,
                'merchant_name' => $merchant->merchant_name,
            ];
        }

        // sort by data terbaru
        usort($list_message_from, function ($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });

        $list_message_from = $this->unique_multidim_array($list_message_from,'from');

        return response()->json($list_message_from, 200);
    }

    // send message from customer to merchant
    public function sendMessage(Request $request)
    {
        $merchant_id = Crypt::decrypt($request->input('to'));
        $merchant    = Merchant::where('id', $merchant_id)->first();
        $message = Chat::create([
            'from'          => $request->input('from'),
            'to'            => $merchant->user_id,
            'message'       => $request->input('message'),
            'attachment'    => $request->input('attachment'),
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'Message sent successfully',
        ], 200);
    }

    // send attachment from customer to merchant
    public function sendAttachment(Request $request)
    {
        $merchant_id = Crypt::decrypt($request->input('to'));
        $merchant    = Merchant::where('id', $merchant_id)->first();
        $input_file  = $request->file('file');
        $extension   = $input_file->getClientOriginalExtension();
        $filename    = time() . '.' . $extension;
        $path        = public_path('assets/img/attachment/customer/');
        $input_file->move($path, $filename);

        $message = Chat::create([
            'from'          => $request->input('from'),
            'to'            => $merchant->user_id,
            'message'       => $request->input('message'),
            'attachment'    => 'assets/img/attachment/customer/'.$filename,
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'Message sent successfully',
        ], 200);
    }


    /**
     * Show the application chat.
     *
     * For Merchant
     */

    public function viewChatMerch($customer_id)
    {
        $customer_id = Crypt::decrypt($customer_id);
        $customer    = Customer::where('id', $customer_id)->first();
        $user        = User::where('id', $customer->user_id)->first();
        // return $customer;
        $avatar      = $user->avatar;

        if($avatar == null) {
            $avatar  = 'assets/img/profile_picture.png';
        }

        if ($customer->fullname == '-') {
            $customer->fullname = $user->username;
        }

        return view('chat.room-merchant',[
            'customer_id' => Crypt::encrypt($customer_id),
            'avatar'      => $avatar,
            'name'        => $customer->fullname,
        ]);
    }

    //get list message to merchant
    public function listChatMerch()
    {
        return view('chat.chat-merchant');
    }

    public function getlist()
    {
        $merchant = auth()->user()->id;
        $chat     = Chat::where('to', $merchant)->get();
        $list_message_from= [];

        foreach ($chat as $key => $value) {
            $user = User::where('id', $value->from)->first();
            $customer = Customer::where('user_id', $value->from)->first();

            if($user->avatar == null) {
                $user->avatar = 'assets/img/profile_picture.png';
            }

            if ($customer->fullname == '-') {
                $customer->fullname = $user->username;
            }

            if ($value->status == 0) {
                $value->status = 'Unread';
            } else {
                $value->status = 'Read';
            }

            $time = date("H:i", strtotime($value->created_at));

            $list_message_from[] = [
                'id'            => $value->id,
                'from'          => $value->from,
                'to'            => $value->to,
                'message'       => $value->message,
                'attachment'    => $value->attachment,
                'status'        => $value->status,
                'customer_name' => $customer->fullname,
                'customer_id'   => Crypt::encrypt($customer->id),
                'avatar'        => $user->avatar,
                'time'          => $time,
                'created_at'    => $value->created_at,
            ];
        }

        // menghapus array data from yang sama

        // sort by data terbaru
        usort($list_message_from, function ($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });

        $list_message_from = $this->unique_multidim_array($list_message_from,'from');

        return response()->json($list_message_from, 200);
    }


    public function getMessageMerch(Request $request)
    {
        $customer_id  = Crypt::decrypt($request->input('customer_id'));
        $user         = auth()->user()->id;
        $customer     = Customer::where('id', $customer_id)->first();
        $chatCust     = Chat::where('from', $customer->user_id)->where('to', $user)->get();
        $chatMerch    = Chat::where('from', $user)->where('to', $customer->user_id)->get();

        $dataMessage = [];
        $dataMerchant = [];
        $dataCustomer = [];

        foreach ($chatCust as $key => $value) {
            $dataCustomer[] = [
                'id'            => $value->id,
                'from'          => $value->from,
                'to'            => $value->to,
                'message'       => $value->message,
                'attachment'    => $value->attachment,
                'status'        => $value->status,
                'created_at'    => $value->created_at,
            ];
        }

        foreach ($chatMerch as $key => $value) {
            $dataMessage[] = [
                'id'            => $value->id,
                'from'          => $value->from,
                'to'            => $value->to,
                'message'       => $value->message,
                'attachment'    => $value->attachment,
                'status'        => $value->status,
                'created_at'    => $value->created_at,
            ];
        }

        $dataMessage = array_merge($dataCustomer, $dataMessage);

       // user defined function for sort by created_at
        usort($dataMessage, function ($a, $b) {
            return $a['created_at'] <=> $b['created_at'];
        });

        return response()->json($dataMessage, 200);
    }

    // send message from merchant to customer
    public function sendMessageMerch(Request $request)
    {
        $customer_id = Crypt::decrypt($request->input('to'));
        $customer    = Customer::where('id', $customer_id)->first();
        $message = Chat::create([
            'from'          => $request->input('from'),
            'to'            => $customer->user_id,
            'message'       => $request->input('message'),
            'attachment'    => $request->input('attachment'),
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'Message sent successfully',
        ], 200);
    }

    // send attachment from customer to merchant
    public function sendAttachmentMerchant(Request $request)
    {
        $customer_id = Crypt::decrypt($request->input('to'));
        $customer    = Customer::where('id', $customer_id)->first();
        $input_file  = $request->file('file');

        $extension   = $input_file->getClientOriginalExtension();
        $filename    = time() . '.' . $extension;

        $path        = public_path('assets/img/attachment/merchant/');
        $input_file->move($path, $filename);

        $message    = Chat::create([
            'from'          => $request->input('from'),
            'to'            => $customer->user_id,
            'message'       => $request->input('message'),
            'attachment'    => 'assets/img/attachment/merchant/'.$filename,
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'Message sent successfully',
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

    function readMessage(Request $request)
    {
        $id = $request->input('id');
        $chat = Chat::where('id', $id)->first();
        $chat->status = 1;
        $chat->save();

        return response()->json([
            'status' => 'Success',
            'message' => 'Message read successfully',
        ], 200);
    }
}
