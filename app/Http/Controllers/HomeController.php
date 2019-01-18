<?php

namespace App\Http\Controllers;

use App\Status;
use App\Usb;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (env('ACTUAL_USER', -1) === -1) {
            return response('<h3>ACTUAL_USER not found into .env. <br/>
            Please create a default ACTUAL_USER="professor" or ACTUAL_USER="secretary" or ACTUAL_USER="admin" in it</h3> ', 500);
        }

        $user = Auth::user()->getAuthIdentifier() . ' ' . Auth::user()->getAuthIdentifierName();

        return view('home', ["usbs" => Usb::all(), "user" => $user]);
    }
}
