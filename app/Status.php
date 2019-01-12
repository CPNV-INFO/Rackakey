<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
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
}
