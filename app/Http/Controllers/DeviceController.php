<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DeviceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // hanya role customer yang bisa mengakses
        $this->middleware(['customer']);
    }


    public function show()
    {
        $user_id = auth()->user()->id;
        $device = Device::where('user_id', $user_id)->paginate(5);

        return view('customer.profile.listDevice',[
                'device' => $device,
            ]
        );
    }

    // get device with query
    public function getDevice(Request $request)
    {

        $search     = $request->query('search');
        $user_id    = auth()->user()->id;
        $device     = Device::where('user_id', $user_id)->get();

        if ($search != NULL)
        {
            $device = Device::where('user_id', $user_id)
                ->where(
                    function ($query) use ($search) {
                        $query->where('device_name', 'LIKE', "%{$search}%");
                    }
                )->get();
        }
        else
        {
            $device = Device::where('user_id', $user_id)->get();
        }

        return response()->json($device);
    }

    public function store(Request $request)
    {
        // get user id
        $user_id    = auth()->user()->id;

        // handle devices picture upload
        $request->validate([
            'device_name'    => 'required',
            'type'           => 'required',
            'brand'          => 'required',
            'serial_number'  => 'required',
            'device_image'   =>'mimes:png,jpeg,jpg|max:2048',
        ]);

        // jika file upload ada maka simpan
        if ($request->hasFile('device_image'))
        {

            $fileName = 'device_'.auth()->user()->username.'_'.time().'.'.$request->device_image->extension();
            $request->device_image->move(public_path('assets/img/devices'), $fileName);

            $filePath = 'assets/img/devices/'.$fileName;
        }
        else
        {
            $filePath = NULL;
        }

        // insert data user profile
        Device::create([
            'user_id'        => $user_id,
            'device_name'    => $request->device_name,
            'type'           => $request->type,
            'brand'          => $request->brand,
            'serial_number'  => $request->serial_number,
            'device_picture' => $filePath,
        ]);

        return back()->with('success', 'Device added successfully');
    }

    public function update(Request $request)
    {
        // get user id
        $user_id    = auth()->user()->id;
        $id         = $request->device;
        $dataDevice = Device::where('user_id', $user_id)->where('id', $id)->first();

        // handle devices picture upload
        $request->validate([
            'edit_device_name'    =>'required',
            'edit_type'           =>'required',
            'edit_brand'          =>'required',
            'edit_serial_number'  =>'required',
            'edit_device_image'   =>'mimes:png,jpeg,jpg|max:2048',
        ]);
        // message errpr
        if ( $request->edit_device_name == NULL || $request->edit_type == NULL || $request->edit_brand == NULL || $request->edit_serial_number == NULL )
        {
            return back()->withInput()->with('error','Please fill all the required fields');
        }

        // jika file upload ada maka simpan
        if ($request->hasFile('edit_device_image'))
        {
            $fileName = 'device_'.auth()->user()->username.'_'.time().'.'.$request->edit_device_image->extension();
            $request->edit_device_image->move(public_path('assets/img/devices'), $fileName);

            $filePath = 'assets/img/devices/'.$fileName;
        }
        elseif ($dataDevice->device_picture != NULL)
        {
            $filePath = $dataDevice->device_picture;
        }
        else
        {
            $filePath = NULL;
        }

        // insert data user profile
        $dataDevice->update([
            'device_name'    => $request->edit_device_name,
            'type'           => $request->edit_type,
            'brand'          => $request->edit_brand,
            'serial_number'  => $request->edit_serial_number,
            'device_picture' => $filePath,
        ]);

        return back()->with('success', 'Device updated successfully');
    }

    public function destroy(Request $request)
    {
        $user_id   = auth()->user()->id;
        $id        = $request->input('id');

        // delete the device
        Devce::where('user_id', $user_id)->where('id', $id)->delete();

        return back()->with('success', 'Device deleted successfully');
    }
}
