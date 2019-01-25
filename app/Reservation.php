<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public function file(){
        return $this->belongsTo('App\File');
    }

    public function usb(){
        return $this->hasMany('App\Usb');
    }

    public function usbs(){
        return $this->belongsToMany('App\Usb');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

//    public function scopeFinished($query){
//        return $query->where('finished', '=', true);
//    }
//
//    public function scopeNotFinished($query){
//        return $query->where('finished', '=', false);
//    }
}
