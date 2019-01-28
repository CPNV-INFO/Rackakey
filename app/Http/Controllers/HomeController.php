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
//
//            $usbs = $usbs->withTrashed();

        $usbsWithTypes["available"]     =  UsbController::getAvailableUsbs();
        $usbsWithTypes["present"]       =  UsbController::getPresentUsbs();
        $usbsWithTypes["used"]          =  UsbController::getUsedUsbs();
        $usbsWithTypes["absent"]        =  UsbController::getAbsentUsbs();
//        $usbsWithTypes["not-initialized"]    =  UsbController::getNotInitializedUsbs();

//        if(Auth::user()->can('viewSoftDelete'))
//            $usbsWithTypes["deleted"] = UsbController::getDeletedUsbs()->get();

        return view('home', ["usbsWithTypes" => $usbsWithTypes, "user" => $user]);
    }
}
