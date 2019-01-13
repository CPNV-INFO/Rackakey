<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function reservation(){
        return $this->hasOne('App\Reservation');
    }
}
