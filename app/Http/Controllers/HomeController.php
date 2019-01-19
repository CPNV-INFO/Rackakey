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

        if(Auth::user()->status == Role::professor()){
            $usbs = Usb::all();
        }else{
            $usbs = Usb::orderBy('status_id', 'desc')->get();

            if(Auth::user()->can('viewSoftDelete')){
                $usbs = Usb::orderBy('status_id', 'desc')->withTrashed()->get();
            }
        }

        return view('home', ["usbs" => $usbs, "user" => $user]);
    }
}
