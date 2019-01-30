<?php

namespace App;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function reservation(){
        return $this->hasOne('App\Reservation');
    }

    static public function scopeWithReservation(Request $request){
        return $request->with('reservation');
    }
}
