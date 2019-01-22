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

    /** Determine wheter the usb key is reserved or not
     *
     */
    public function isReserved(){
//        echo $this->reservations()->latest()->toJson();


//        return $this->reservations();
    }

    /** Determines wheter the usb key is in the hub or not
     *
     */
    public function isInTheHub(){
        return ($this->rack_number == 0) ? false : true;
    }

    /** Determine wheter the usb key is used right now or not
     *
     */
    public function scopeUsed(){

    }

    /** Determine wheter the usb key is absent right now or not
     *
     */
    public function scopeAbsent(){
        return false;
    }

    /** Determine wheter the usb key is present right now or not
     *
     */
    public function scopePresent(){

    }

    /** Determine wheter the usb key is available right now or not
     *
     */
    public function scopeAvailable(){

    }

    /** Determine wheter the usb key is not initialized right now or not
     *
     */
    public function notInitialized(){

    }

    /** Determine wheter the usb key is deleted right now or not
     *
     */
    public function alreadyDeleted(){

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
}
