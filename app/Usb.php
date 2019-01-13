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
}
