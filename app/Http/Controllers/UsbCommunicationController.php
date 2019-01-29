<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsbCommunicationController extends Controller
{
    static public function sendFileToUsb($zipPath){
        // Todo: Here must be implemented the logic that will send the zip file to the usb
        // Info: The $zipPath is a static link to zip file (sotcked in storage/app/reservations/reservation_X/filesToUsb.zip
    }
}
