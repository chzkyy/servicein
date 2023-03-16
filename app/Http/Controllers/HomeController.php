<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // get data session
        // $data = session()->all();
        // // $data = 'dsadad';
        // $data = json_encode($data);
        // // get data auth
        // $dataUser = auth()->user();
        // $dataUser = json_encode($dataUser);



        return view('home', 
            //compact('data', 'dataUser')
        );

    }
}
