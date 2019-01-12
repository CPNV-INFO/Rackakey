<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public function file(){
        return $this->belongsTo('App\File');
    }

    public function usb(){
        return $this->belongsToMany('App\Usb');
    }
}
