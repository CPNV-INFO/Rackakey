<?php

namespace App\Http\Controllers;

use App\Status;
use App\Usb;
use Illuminate\Http\Request;
use Session;

class UsbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Usb $usb
     * @return \Illuminate\Http\Response
     */
    public function show(Usb $usb)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Usb $usb
     * @return \Illuminate\Http\Response
     */
    public function edit(Usb $usb)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Usb $usb
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usb $usb)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  \App\Usb $usb
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Usb $usb)
    {
        $usb->delete();
        $usb->status_id = Status::notActive();
        $usb->save();

        $this->createFlashMessage($request, $usb, "supprimée", "info");

        return redirect('/home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $usb = Usb::withTrashed()->find($id);
        $usb->restore();
        $usb->status_id = Status::notActive();
        $usb->save();

        $this->createFlashMessage($request, $usb, "restaurée", "success");

        return redirect('/home');
    }

    public function initialize(Request $request, $id)
    {
        $usb = Usb::find($id);
        $usb->status_id = Status::active();
        $usb->save();

        $this->createFlashMessage($request, $usb, "initialisée", "success");
        return redirect('/home');
    }

    public function createFlashMessage($request, $usb, $word, $type)
    {
        $statusName = $usb->status->name;
        $request->session()->flash('flashmessage', [
            "message" => "$usb->name 
            (Numéro clé: $usb->id, 
            status: $statusName, 
            Rack: $usb->rack_number, 
            Port: $usb->port_number) a bien été $word",
            "type" => $type
        ]);
    }

    /** Returns all available usb keys
     *  INFO: Available are the usbs that:
     *          - Are active AND
     *          - Are in the rack AND
     *          - Are not reserved OR
     *          - That doesn't have any reservation at all
     */
    public static function getAvailableUsbs()
    {
        // INFO: notReserved() returns nothing if there is no relation between Usb and Reservation.
        //       so we do another request to get the same type of usb but without relation at all (reservation)
        $availableUsbWithOneOrMoreReservation       = Usb::activeUsb()->notReserved()->inRack()->get();
        $availableUsbNoneReservation                = Usb::activeUsb()->inNoneReservation()->inRack()->get();

//        dd($availableUsbWithOneOrMoreReservation->last()->reservation());

        $result = $availableUsbWithOneOrMoreReservation->merge($availableUsbNoneReservation);

        return $result;
    }

    /** Returns all present usb keys
     *  INFO: Present are the usbs that:
     *          - Are active AND
     *          - Are in the rack AND
     *          - Are reserved
     *
     *      Idea: Maybe some person could forget that they have reserved a usb (for any reason/error),
     *            should it have a notification that tells for example when
     *            a usb has been present for too much time ?
     */
    public static function getPresentUsbs()
    {
        return Usb::activeUsb()->reserved()->inRack()->get();
    }

    /** Returns all absent usb keys
     *  INFO: Absent are the usbs that:
     *          - Are active AND
     *          - Are not in the rack AND
     *          - Are not reserved
     *          - That doesn't have any reservation at all
     */
    public static function getAbsentUsbs()
    {
        $absent = Usb::not§Reserved()->activeUsb()->notInRack();
        return $absent;
    }

    /** Returns all used usb keys
     *  INFO: Used are the usbs that:
     *          - Are active AND
     *          - Are not in the rack AND
     *          - Are reserved
     */
    public static function getUsedUsbs()
    {
        return Usb::activeUsb()->reserved()->notInRack();
    }

    /** Returns all not initialized usb keys
     *  INFO: Not initialized are the usbs that:
     *          - Are not active AND
     *          - Are in the rack AND
     *          - Are not reserved
     */
    public static function getNotInitializedUsbs()
    {
        return Usb::notReserved()-> notActiveUsb();
    }

    /** Returns all deleted usb keys
     *
     */
    public static function getActiveUsbs()
    {
        return Usb::activeUsb();
    }

    /** Returns all deleted usb keys
     *
     */
    public static function getDeletedUsbs()
    {
        return Usb::onlyTrashed();
    }
}
