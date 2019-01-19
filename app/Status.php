<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $timestamps = false;

    public function usb(){
        return $this->hasOne('App\Usb');
    }

    public function scopeAvailable($query){
        return $query->where('name', 'Disponible')->first()->id;
    }

    public function scopePresent($query){
        return $query->where('name', 'Présente')->first()->id;
    }

    public function scopeAbsent($query){
        return $query->where('name', 'Absente')->first()->id;
    }

    public function scopeUsed($query){
        return $query->where('name', 'Utilisée')->first()->id;
    }

    public function scopeNotInitialized($query){
        return $query->where('name', 'Non Initialisée')->first()->id;
    }

    // Here we don't use scopeDeleted as a name because deleted() already exists in query
    public function scopeAlreadyDeleted($query){
        return $query->where('name', 'Supprimée')->first()->id;
    }
}
