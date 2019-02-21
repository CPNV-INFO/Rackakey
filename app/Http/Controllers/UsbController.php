<?php

namespace App\Http\Controllers;

use App\FlashMessage;
use App\Status;
use App\Usb;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Session;

class UsbController extends Controller
{
    protected $usbRepository;
    protected $nbrPerPage = 4;

    public function index()
    {

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

        FlashMessage::flash("usbAction", $request,
            [
                "usb" => $usb,
                "actionMessage" => "supprimée",
                "alertType" => "info"
            ]
        );

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

        FlashMessage::flash("usbAction", $request,
            [
                "usb" => $usb,
                "actionMessage" => "restaurée",
                "alertType" => "success"
            ]
        );

        return redirect('/home');
    }

    public function initialize(Request $request, $id)
    {
        $usb = Usb::find($id);
        $usb->status_id = Status::active();
        $usb->save();

        FlashMessage::flash("usbAction", $request,
            [
                "usb" => $usb,
                "actionMessage" => "initialisée",
                "alertType" => "success"
            ]
        );


        return redirect('/home');
    }

    public function in(Request $request, $id)
    {
        $usb = Usb::withTrashed()->find($id);
        $usb->rack_number = 1; // Number taken for test only
        $usb->port_number = 1; // Number taken for test only
        $usb->save();

        FlashMessage::flash("usbAction", $request,
            [
                "usb" => $usb,
                "actionMessage" => "entrée dans le hub (simulation)",
                "alertType" => "info"
            ]
        );

        return redirect('/home');
    }

    public function out(Request $request, $id)
    {
        $usb = Usb::withTrashed()->find($id);
        $usb->rack_number = 0; // Number taken for test only
        $usb->port_number = 0; // Number taken for test only
        $usb->save();

        FlashMessage::flash("usbAction", $request,
            [
                "usb" => $usb,
                "actionMessage" => "retirée du hub (simulation)",
                "alertType" => "info"
            ]
        );

        return redirect('/home');
    }

    /** Returns all available usb keys
     *  INFO: Available are the usbs that:
     *          - Are active AND
     *          - Are in the rack AND
     *          - Are not actually reserved OR
     *          - That doesn't have any reservation at all
     */
    public static function getAvailableUsbs()
    {
        $availableCollection = collect();

        $usbWithReservation = Usb::activeUsb()->inRack()->hasReservation()->orderByReservationDate()->get();

        // Let's check for every usb if their last reservation is NOT actually reserved (finished = true)
        foreach ($usbWithReservation as $usb) {
            if ($usb->reservation->first()->finished)
                $availableCollection->prepend($usb);
        }

        $availableWithoutAnyReservation = Usb::activeUsb()->inRack()->inNoneReservation()->get();

        $available = $availableCollection->merge($availableWithoutAnyReservation);

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
     *            a usb has been in present state for too much time ?
     */
    public static function getPresentUsbs()
    {
        $presentCollection = collect();

        $usbWithReservation = Usb::activeUsb()->inRack()->hasReservation()->orderByReservationDate()->get();

        // Let's check for every usb if their last reservation is actually reserved (finished = false)
        foreach ($usbWithReservation as $usb) {
            if (!$usb->reservation->first()->finished)
                $presentCollection->prepend($usb);
        }

        return $presentCollection;
    }

    /** Returns all absent usb keys
     *  INFO: Absent are the usbs that:
     *          - Are active AND
     *          - Are not in the rack AND
     *          - Are not actually reserved OR
     *          - That doesn't have any reservation at all
     */
    public static function getAbsentUsbs()
    {
        $absentCollection = collect();

        $usbWithReservation = Usb::activeUsb()->notInRack()->hasReservation()->orderByReservationDate()->get();

        // Let's check for every usb if their last reservation is NOT actually reserved (finished = true)
        foreach ($usbWithReservation as $usb) {
            if ($usb->reservation->first()->finished)
                $absentCollection->prepend($usb);
        }

        $absentWithoutAnyReservation = Usb::activeUsb()->notInRack()->inNoneReservation()->get();

        $absent = $absentCollection->merge($absentWithoutAnyReservation);

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
        $usedCollection = collect();

        $usbWithReservation = Usb::activeUsb()->notInRack()->hasReservation()->orderByReservationDate()->get();

        // Let's check for every usb if their last reservation is actually reserved (finished = false)
        foreach ($usbWithReservation as $usb) {
            if (!$usb->reservation->first()->finished)
                $usedCollection->prepend($usb);
        }

        return $usedCollection;
    }

    /** Returns all not initialized usb keys
     *  INFO: Not initialized are the usbs that:
     *          - Are not active AND
     *          - Are in the rack
     */
    public static function getNotInitializedUsbs()
    {
        return Usb::notActiveUsb()->inRack()->get();
    }

    /** Returns all usbs that were pulled without beeing initialized first
     *   Keep in mind that each usb entering the usb hub is directly created
     *   into the database when not already existent and has a default "not initialized" state
     *
     *  INFO: Pulled without beeing initialized are the usbs that:
     *          - Are not active AND
     *          - Are not in the rack
     */
    public static function getPulledAndNotInizialedUsbs()
    {
        return Usb::notActiveUsb()->notInRack()->get();
    }

    /** Returns all deleted usb keys
     *
     */
    public static function getDeletedUsbs()
    {
        return Usb::onlyTrashed();
    }
}
