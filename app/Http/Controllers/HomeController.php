<?php

namespace App\Http\Controllers;

use App\Role;
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
        $user = Auth::user()->firstName . '.' . strtoupper(Auth::user()->lastName);


//        $usbs = Usb::orderBy('status_id');
//
//        if(Auth::user()->can('viewSoftDelete'))
//            $usbs = $usbs->withTrashed();

        return view('home', ["availableUsbs" => UsbController::getAvailableUsbs(), "user" => $user]);
    }
}
