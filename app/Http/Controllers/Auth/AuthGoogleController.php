<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

use Auth;
use Socialite;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class AuthGoogleController extends Controller
{
    /**
     * Controller untuk login menggunakan google
     *
     */

    // redirect ke halaman google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // handle callback setelah login
    public function callback()
    {
        // jika user masih login lempar ke home
        if (Auth::check()) {
            return redirect('/');
        }

        // ambil data user dari google
        $user = Socialite::driver('google')->stateless()->user();

        // cek apakah user sudah pernah login menggunakan google
        $existingUser = User::where('google_id', $user->id)->first();
        $existEmail   = User::where('email', $user->email)->first();

        // generate nickname berdasarkan email
        $username = explode('@', $user->email);
        $username = $username[0];

        // jika belum ada buat user baru
        if (!$existingUser && !$existEmail) {
            $user = User::create([
                'google_id' => $user->id,
                'fullname'  => $user->name,
                'username'  => $username,
                'avatar'    => $user->avatar,
                'email'     => $user->email,
                // 'password'  => bcrypt('P@ssw0rd'),
            ]);

            // kirim email notifikasi
            event(new Registered($user));
            // login user
            auth('web')->login($user);
            return redirect()->to('/choose');
        }
        else if ($existEmail->google_id == null) {
            User::where('email', $user->email)->update([
                'google_id' => $user->id,
            ]);

            // login user
            auth('web')->login($existEmail);
            if ($existEmail->role == null) {
                return redirect()->to('/choose');
            }
            else {
                return redirect()->to('/');
            }
        }
        else {
            auth('web')->login($existingUser);
            if ($existingUser->role == null) {
                return redirect()->to('/choose');
            }
            else {
                return redirect()->to('/');
            }
        }
    }
}
