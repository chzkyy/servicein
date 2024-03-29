<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Merchant;
use App\Models\MerchantGallery;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // hanya role merchant yang bisa mengakses
        $this->middleware(['merchant']);
    }

    // public function index()
    // {
    //     return view('adminToko.testMaps');
    // }


    protected function update_merchant(Request $request)
    {
        $user_id = auth()->user()->id;

        Merchant::where('user_id', $user_id)->update([
            'merchant_name'         => $request->merchant_name,
            'merchant_desc'         => $request->merchant_desc,
            'merchant_address'      => $request->merchant_address,
            'open_hour'             => $request->open_hour,
            'close_hour'            => $request->close_hour,
            'phone_number'          => $request->phone_number,
            'geo_location'          => $request->geo_location,

        ]);

        return redirect()->route('profile.admin')->with('success', 'Profile updated successfully');
    }

    protected function createMerchantGallery(array $data)
    {
        return MerchantGallery::create([
            'merchant_id'           => $data['merchant_id'],
            'images'                => $data['images'],
        ]);
    }

    public function merchant()
    {
        $user_id            = auth()->user()->id;
        $merchant           = Merchant::where('user_id', $user_id)->first();
        $percentage         = $this->show_percentage($user_id);
        $ava                = auth()->user()->avatar;
        $imageGallery       = $this->show_image_gallery($merchant->id);

        if ( $ava == null )
        {
            $ava = NULL;
        }
        else if ( $ava == str_contains($ava, 'https') )
        {
            $ava = $ava;
        }
        else if( $ava == str_contains($ava, 'assets/img/profile')) {
            $ava = asset($ava);
        }

        return view('adminToko.index',
            [
                'photos'     => $imageGallery,
                'merchant'   => $merchant,
                'percentage' => $percentage,
                'avatar'     => $ava,
            ]
        );
    }

    public function edit_merchant()
    {
        $user_id    = auth()->user()->id;
        $merchant   = Merchant::where('user_id', $user_id)->first();
        $percentage = $this->show_percentage($user_id);
        $ava        = auth()->user()->avatar;

        if ( $ava == null )
        {
            $ava = NULL;
        }
        else if ( $ava == str_contains($ava, 'https') )
        {
            $ava = $ava;
        }
        else if( $ava == str_contains($ava, 'assets/img/profile')) {
            $ava = asset($ava);
        }
        return view ('adminToko.edit',
            [
                'merchant'   => $merchant,
                'percentage' => $percentage,
                'avatar'     => $ava,
            ]
        );
    }

    public function update_avatar(Request $request)
    {
        // get user id
        $user_id    = auth()->user()->id;
        // get username
        $username   = auth()->user()->username;

        // Handle File Upload
        $request->validate([
            'profile_picture' => 'required|mimes:png,jpeg,jpg|max:2048',
        ],
        [
            'profile_picture.required' => 'Please select an image to upload.',
            'profile_picture.mimes' => 'Sorry! Only JPG, JPEG, PNG files are allowed.',
            'profile_picture.max' => 'Sorry! Maximum allowed size for an image is 2MB.',
        ]);

        $fileName = $username.'.'.$request->profile_picture->extension();
        $request->profile_picture->move(public_path('assets/img/profile'), $fileName);

        // update data user profile
        User::where('id', $user_id)->update([
            'avatar' => "assets/img/profile/".$fileName,
        ]);

        return redirect()->back()->with('success','Avatar updated successfully.')->with('file', $fileName);
    }

    public function merchant_gallery(Request $request)
    {
         // get user id
        $user_id    = auth()->user()->id;
         // get username
        $username   = auth()->user()->username;

        // Handle File Upload
        $request->validate([
            // imzge validation max 2MB
            'photos' => 'required',
            'photos.*' => 'required|image' // max 2MB = 2048
        ],[
            'photos.required' => 'Please select at least 1 image to upload.',
            'photos.*.required' => 'Please select at least 1 image to upload.',
            'photos.*.image' => 'Sorry! Only JPG, JPEG, PNG & GIF files are allowed.',
        ]);

        // if validation success
        if( $request->hasfile('photos') )
        {
            // multiple file upload
            $arr = [];

            foreach ($request->file('photos') as $file) {
                $fileName     = $file->getClientOriginalName();
                $file->move(public_path('assets/img/merchant_gallery/'.$username), $fileName);
                $arr[] = $fileName;
            }

            // insert data to database
            foreach ($arr as $key => $value) {
                $data = [
                    'merchant_id'   => $request->merchant_id,
                    'images'        => "assets/img/merchant_gallery/".$username.'/'.$value,
                ];

                $this->createMerchantGallery($data);
            }

            return response()->json([
                'message' => 'Your images has been successfully upload.'
            ], 200);
        }
        else
        {
            return response()->json([
                'message' => 'Please select at least 1 image to upload.'
            ], 422);
        }
    }


    // function for deleting merchant gallery
    public function delete_merchant_gallery(Request $request)
    {
        $id = $request->id;
        $merchantGallery = MerchantGallery::findOrFail($id);
        $merchantGallery->delete();

        return $merchantGallery;
    }

    public function deleteMerchantGallery($id)
    {
        $merchantGallery = MerchantGallery::findOrFail($id);
        $merchantGallery->delete();

        return $merchantGallery;
    }
    // function for show percentage of profile
    public function show_percentage($id)
    {
        $merchant = Merchant::where('user_id', $id)->first();
        $percentage = 0;

        if ($merchant->merchant_name != '-') {
            $percentage += 100/7;
        }
        if ($merchant->merchant_desc != '-') {
            $percentage += 100/7;
        }
        if ($merchant->merchant_address != '-') {
            $percentage += 100/7;
        }
        if ($merchant->phone_number != '-') {
            $percentage += 100/7;
        }
        if ($merchant->open_hour != '-') {
            $percentage += 100/7;
        }
        if ($merchant->close_hour != '-') {
            $percentage += 100/7;
        }
        if ($merchant->geo_location != '-') {
            $percentage += 100/7;
        }

        return round($percentage);
    }

    public function show_image_gallery($id)
    {
        $imageGallery = MerchantGallery::where('merchant_id', $id)->get();

        $arr = [];

        foreach ($imageGallery as $key => $value) {
            // id: 1, src: 'https://picsum.photos/500/500?random=1'}
            $arr[] = [
                'id'    => $value->id,
                'src'   => asset($value->images),
            ];
        }

        return $arr;
    }
}
