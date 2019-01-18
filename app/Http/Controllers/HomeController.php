<?php

namespace App\Http\Controllers;

use App\Status;
use App\Usb;
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
            return back()->withErrors('ACTUAL_USER not found into .env. Please create a default ACTUAL_USER="professor"');
        }

        $user = env('ACTUAL_USER', -1);

        if( env('ACTUAL_USER') === "professor"){
            $usb = Usb::where('status_id', '=', Status::available())->get();
        }else if(env('ACTUAL_USER') === "secretary"){
            $usb = Usb::where('status_id', '=', Status::available())
                ->orWhere('status_id', '=', Status::present())
                ->orWhere('status_id', '=', Status::notInitialized())->get();
        }else if(env('ACTUAL_USER') === "admin"){
            $usb = Usb::where('status_id', '=', Status::available())
                ->orWhere('status_id', '=', Status::present())
                ->orWhere('status_id', '=', Status::absent())
                ->orWhere('status_id', '=', Status::used())
                ->orWhere('status_id', '=', Status::notInitialized())
                ->get();
        }

//        dd($usb);
        return view('home', ["usb" => $usb, "user" => $user]);
    }
}
