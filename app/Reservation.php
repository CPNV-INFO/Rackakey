<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function file(){
        return $this->belongsTo('App\File');
    }

    public function usb(){
        return $this->hasMany('App\Usb');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function scopeFinished($query){
        return $query->where('finished', '=', true);
    }

    public function scopeNotFinished($query){
        return $query->where('finished', '=', false);
    }

    /** Returns usb last reservation
     *
     * @param $query
     * @return mixed
     */
    public function scopeLastReservation($query)
    {
        return $query->orderBy('date_reserved', 'desc')->limit(1);
    }
}
