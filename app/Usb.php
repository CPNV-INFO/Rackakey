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
}
