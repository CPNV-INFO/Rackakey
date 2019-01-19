<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usb extends Model
{
    public function status(){
        return $this->belongsTo('App\Status');
    }

    public function reservation(){
        return $this->belongsToMany('App\Reservation');
    }

    static public function formatFileSize($size)
    {
        $actualSize = $size;
        $units = array( 'B', 'KB', 'MB', 'GB', 'TB');
        $power = $actualSize > 0 ? floor(log($actualSize, 1024)) : 0;
        return number_format($actualSize / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];

    }
}
