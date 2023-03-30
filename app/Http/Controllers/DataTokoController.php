<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataTokoController extends Controller
{
    //

    public function index()
    {
        return view('adminToko.testMaps');
    }
}
