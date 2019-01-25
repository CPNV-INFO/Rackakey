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
        $usb->status_id = Status::alreadyDeleted();
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
        $usb->status_id = Status::notInitialized();
        $usb->save();

        $this->createFlashMessage($request, $usb, "restaurée", "success");

        return redirect('/home');
    }

    public function initialize(Request $request, $id)
    {
        $usb = Usb::find($id);
        $usb->status_id = Status::available();
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

    /** Returns available usbs
     *
     **/
    public static function getAvailableUsbs()
    {
        return Usb::openedReservation();
    }

    /** Returns all absent key
     *  Condition for a usb to be absent:
     *  - The key is not reserved at all OR the last reservation is not finished
     *  - The key is not into a hub (the rack_number is equal to 0)
     */
    public static function getAbsentUsbs()
    {
        $usb = Usb::hasNot('reservations')->whereHas('reservations', function($query){

        })->where('rack_number', '=', 0)->get();

        return $usb;
    }

//    /** Determine wheter the usb key is reserved or not
//     * @param Usb $usb
//     */
//    public function isReserved(Usb $usb){
//
//    }

//    /** Determines wheter the usb key is in the hub or not
//     *
//     */
//    public function isInTheHub(Usb $usb){
//
//        return ($this->rack_number == 0) ? false : true;
//    }
//
//    /** Determine wheter the usb key is used right now or not
//     *
//     */
//    public function scopeUsed(){
//
//    }
//
//    /** Determine wheter the usb key is absent right now or not
//     *
//     */
//    public function scopeAbsent(){
//        return false;
//    }
//
//    /** Determine wheter the usb key is present right now or not
//     *
//     */
//    public function scopePresent(){
//
//    }
//
//    /** Determine wheter the usb key is available right now or not
//     *
//     */
//    public function scopeAvailable(){
//
//    }
//
//    /** Determine wheter the usb key is not initialized right now or not
//     *
//     */
//    public function notInitialized(){
//
//    }
//
//    /** Determine wheter the usb key is deleted right now or not
//     *
//     */
//    public function alreadyDeleted(){
//
//    }
}
