<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

class NotificationController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
    }


    public function index()
    {
        $user = Auth::user();

        // check if user is customer or merchant
        $notifications = Notification::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(10);
        if ($user->role == 'Admin') {
            return view('notifications.admin.index', [
                'notif' => $notifications
            ]);
        } else {
            return view('notifications.index', [
                'notif' => $notifications
            ]);
        }
    }

    public function view_admin()
    {
        $user = Auth::user();
        $notifications = Notification::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('notifications.admin.index', [
            'notif' => $notifications
        ]);
    }

    public function getNotification()
    {
        $user = Auth::user();
        $notifications = Notification::where('user_id', $user->id)
                        ->where('status', 0)
                        ->orderBy('created_at', 'desc')
                        ->limit(3)
                        ->get();

        $all           = Notification::where('user_id', $user->id)
                        ->where('status', 0)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->json(
            [
                'code'      => 200,
                'message'   => 'success',
                'all_notif' => count($all),
                'data'      => $notifications
            ]
        );
    }

    public function readNotification(Request $request)
    {
        $id = $request->input ('id');
        $notification = Notification::find($id);
        $notification->status = 1;
        $notification->save();
        return response()->json([
            'code' => 200,
            'message' => 'success, notification has been read'
        ]);
    }

}
