<?php

namespace App\Http\Controllers;

use App\Status;
use App\Usb;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
     *          - Are actually not reserved OR
     *          - That doesn't have any reservation at all
     */
    public static function getAvailableUsbs()
    {
        $availableCollection = collect();

        $activeAndInRackReserved = Usb::activeUsb()->inRack()->hasReservation()->orderByReservationDate()->get();

        // Let's check for every usb if their last reservation is NOT actually reserved (finished = true)
        foreach ($activeAndInRackReserved as $usb){
            if($usb->reservation->first()->finished)
                $availableCollection->prepend($usb);
        }

        $availableUsbNoneReservation = Usb::activeUsb()->inRack()->inNoneReservation()->get();
        $available = $availableCollection->merge($availableUsbNoneReservation);

        return $available;
    }


    /** Returns all present usb keys
     *  INFO: Present are the usbs that:
     *          - Are active AND
     *          - Are in the rack AND
     *          - Are actually reserved
     *
     *      Idea: Maybe some person could forget that they have reserved a usb (for any reason/error),
     *            should it have a notification that tells for example when
     *            a usb has been present for too much time ?
     */
    public static function getPresentUsbs()
    {
        $presentCollection = collect();

        $activeAndInRack = Usb::activeUsb()->inRack()->hasReservation()->orderByReservationDate()->get();

        // Let's check for every usb if their last reservation is actually reserved (finished = false)
        foreach ($activeAndInRack as $usb){

            if(!$usb->reservation->first()->finished)
                $presentCollection->prepend($usb);
        }

        return $presentCollection;
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
        // Todo: add that it needs to get the ones that doesn't have any reservation at all
//        $absent = Usb::activeUsb()->notReserved()->notInRack()->get();

        $absentUsbWithOneOrMoreRelation     = Usb::activeUsb()->notReserved()->notInRack()->get();
        $absentUsbWithoutRelation           = Usb::activeUsb()->inNoneReservation()->notInRack()->get();

        $absent = $absentUsbWithOneOrMoreRelation->merge($absentUsbWithoutRelation);

        return $absent;
    }

    /** Returns all used usb keys
     *  INFO: Used are the usbs that:
     *          - Are active AND
     *          - Are not in the rack AND
     *          - Are actually reserved
     */
    public static function getUsedUsbs()
    {
//        return Usb::activeUsb()->reserved()->lastReservation()->notInRack()->get();

        $usedCollection = collect();

        $activeAndNotInRack = Usb::activeUsb()->notInRack()->hasReservation()->orderByReservationDate()->get();

        // Let's check for every usb if their last reservation is actually reserved (finished = false)
        foreach ($activeAndNotInRack as $usb){

            if(!$usb->reservation->first()->finished)
                $usedCollection->prepend($usb);
        }

        return $presentCollection;


    }

    /** Returns all not initialized usb keys
     *  INFO: Not initialized are the usbs that:
     *          - Are not active AND
     *          - Are in the rack AND
     *          - Are actually not reserved
     */
    public static function getNotInitializedUsbs()
    {
        return Usb::notReserved()->notActiveUsb()->get();
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
