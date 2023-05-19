<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyController extends Controller
{
    //

    public function PrivacyPolicy()
    {
        return view('policy.privacy-policy');
    }
}
