<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usb extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function status(){
        return $this->belongsTo('App\Status');
    }

    public function reservation(){
        return $this->belongsToMany('App\Reservation');
    }

    public function reservations(){
        return $this->belongsToMany('App\Reservation');
    }

    /** Format the bytes into sizes like kb, mb, gb...
     * @param $size
     * @return string
     */
    static public function formatFileSize($size)
    {
        $actualSize = $size;
        $units = array( 'B', 'KB', 'MB', 'GB', 'TB');
        $power = $actualSize > 0 ? floor(log($actualSize, 1024)) : 0;
        return number_format($actualSize / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    /** Returns usb that are IN the rack
     *
     * @param $query
     * @return mixed
     */
    public function scopeInRack($query){
        return $query->where('rack_number', '!=', 0);
    }

    /** Returns usb that are NOT the rack
     *
     * @param $query
     * @return mixed
     */
    public function scopeNotInRack($query){
        return $query->where('rack_number', '=', 0);
    }

    /** Returns usb that are in a reservation
     *
     * @param $query
     * @return mixed
     */
    public function scopeOpenedReservation($query){
        return $this->with('reservation')->notFinished();
    }

    /** Returns usb that are in a reservation
     *
     * @param $query
     * @return mixed
     */
    public function scopeClosedReservation($query){
        return $this->with('reservation')->finished();
    }

}
