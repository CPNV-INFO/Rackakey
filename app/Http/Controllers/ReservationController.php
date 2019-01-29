<?php

namespace App\Http\Controllers;

use App\File;
use App\FlashMessage;
use App\Http\Requests\ReservationRequest;
use App\Reservation;
use App\Usb;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ZanySoft\Zip\Zip;

class ReservationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("reservation");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(ReservationRequest $request)
    {
        $validated = $request->validated();
        $usbIdWithEnoughSpace = $this->checkIfEnoughUsbForThisSpace($request);
        if(!$usbIdWithEnoughSpace){
            return redirect('/reservation');
        }

        $fileId = FileController::createFile($request);

        UsbCommunicationController::sendFileToUsb(File::find($fileId)->nameOfCompressedFile);

        $reservation = new Reservation();
        $reservation->name              =  $request->reservation_name;
        $reservation->date_reserved     =  now();
        $reservation->date_returned     =  null;
        $reservation->user_id           =  Auth::user()->id;
        $reservation->file_id           =  $fileId;
        $reservation->finished          =  false;
        $reservation->save();

        $reservation->usb()->attach($usbIdWithEnoughSpace);

        FlashMessage::flash("personalized", $request,
            [
                "message" => "Votre réservation a bien été prise en compte. Référez-vous au tableau de vos réservations pour plus d'informations",
                "alertType" => "success"
            ]
        );

        return redirect('reservation');
    }

    public function checkIfEnoughUsbForThisSpace(ReservationRequest $request)
    {
        $totalSize = 0;
        $numberUsbWantedLeft = $request->number_keys;

        // Let's first get the total amount of space we need in total
        foreach ($request->file('files') as $file) {
            $totalSize += $file->getSize();
        }

        $usbIdWithEnoughSpace = array();
        // Let's first check if there is available usb with the size we want before we continue !
        foreach (UsbController::getAvailableUsbs() as $usb) {
            if ($usb->freeSpaceInBytes > $totalSize) {
                $usbIdWithEnoughSpace[] = $usb->id;

                $numberUsbWantedLeft -= 1;

                if ($numberUsbWantedLeft == 0)
                    break;
            }
        }

        // If enough usbs with the good amount of available space have been found,
        // the $numberUsbWantedLeft should be zero.
        // If it is not, it means we don't have enough usb with the space we want so we return back with a message
        if ($numberUsbWantedLeft > 0) {

            FlashMessage::flash("personalized", $request,
                [
                    "message" => "Malheureusement il n'y a pas assez d'usbs disponibles avec l'espace demandé pour satisfaire votre demande",
                    "alertType" => "danger"
                ]
            );

            return false;
        }

        return $usbIdWithEnoughSpace;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
