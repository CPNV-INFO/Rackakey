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

//    public function usb(){
//        return $this->hasMany('App\Usb');
//    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function usb(){
        return $this->belongsToMany('App\Usb');
    }

    public function scopeFinished($query){
        return $query->withUser()->where('finished', '=', true);
    }

    public function scopeNotFinished($query){
        return $query->withUser()->where('finished', '=', false);
    }

    /** Returns usb last reservation
     *
     * @param $query
     * @return mixed
     */
    public function scopeOrderByReservationDate($query)
    {
        return $query->withUser()->orderBy('date_reserved', 'desc');
    }

    /** Returns the users with the requests
     *
     * @param $query
     * @return mixed
     */
    public function scopeWithUser($query)
    {
        return $query->with('user');
    }
}
