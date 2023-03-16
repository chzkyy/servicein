<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ChooseRoleController extends Controller
{
    // // logout
    // public function logout(Request $request)
    // {
    //     auth('web')->logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect('/');
    // }


    public function chooseRole()
    {
        return view('auth.choose-role');
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
