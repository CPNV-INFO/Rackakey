<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usb extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function reservation()
    {
        return $this->belongsToMany('App\Reservation');
    }

    /** Format the bytes into sizes like kb, mb, gb...
     * @param $size
     * @return string
     */
    static public function formatFileSize($size)
    {
        $actualSize = $size;
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $power = $actualSize > 0 ? floor(log($actualSize, 1024)) : 0;
        return number_format($actualSize / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    /** Returns usb that are IN the rack
     *
     * @param $query
     * @return mixed
     */
    public function scopeInRack($query)
    {
        return $query->where('rack_number', '!=', 0);
    }

    /** Returns usb that are NOT in the rack
     *
     * @param $query
     * @return mixed
     */
    public function scopeNotInRack($query)
    {
        return $query->where('rack_number', '=', 0);
    }

    /** Returns usb that are already reserved
     *
     * @param $query
     * @return mixed
     */
    public function scopeReserved($query)
    {
        return $query->whereHas('reservation', function ($subQuery) {
            $subQuery->notFinished();
        });
    }

    /** Returns usb that are not actually reserved
     *
     * @param $query
     * @return mixed
     */
    public function scopeNotReserved($query)
    {
        return $query->whereHas('reservation', function ($query) {
            $query->finished();
        });
    }

    /** Returns the last reservation for this usb
     *
     * @param $query
     * @return mixed
     */
    public function scopeLastReservation($query)
    {
        return $query->with(['reservation' => function ($subQuery) {
            $subQuery->lastReservation();
        }]);
    }

    /** Returns the reservations ordered by date
     *
     * @param $query
     * @return mixed
     */
    public function scopeOrderByReservationDate($query)
    {
        return $query->with(['reservation' => function ($subQuery) {
            $subQuery->orderByReservationDate();
        }]);
    }

    /** Returns the ones that have reservation
     *
     * @param $query
     * @return mixed
     */
    public function scopeHasReservation($query)
    {
        return $query->has('reservation');
    }



    /** Returns the last reservation for this usb
     *
     * @param $query
     * @return mixed
     */
    public function scopeWithReservation($query)
    {
        return $query->with('reservation');
    }

    /** Returns usb that doesn't have any reservation
     *
     * @param $query
     * @return mixed
     */
    public function scopeInNoneReservation($query)
    {
        return $query->doesntHave('reservation');
    }

    /** Returns usb that aren't active
     *
     * @param $query
     * @return mixed
     */
    public function scopeNotActiveUsb($query)
    {
        return $query->where('status_id', '=', Status::notActive());
    }

    /** Returns usb that are active
     *
     * @param $query
     * @return mixed
     */
    public function scopeActiveUsb($query)
    {
        return $query->where('status_id', '=', Status::active());
    }
}
