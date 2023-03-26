<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ChooseRoleController extends Controller
{
    public function chooseRole()
    {
        $user = Auth::user();
        // check user login
        if ($user) {
            // check user role
            if ($user->role == 'Admin') {
                return redirect()->to('/admin');
            } elseif ($user->role == 'User') {
                return redirect()->to('/');
            } else {
                return view('auth.choose-role');
            }
        } else {
            return redirect()->to('/login');
        }
    }

    public function storeRole(Request $request)
    {
        // get user id
        $id = Auth::user()->id;

        // update role
        User::where('id', $id)->update([
            'role' => $request->role
        ]);

        // set add role to session
        $request->session()->put('role', $request->role);

        // echo data
        // echo $request->role;
        return redirect()->to('/');
    }
}
