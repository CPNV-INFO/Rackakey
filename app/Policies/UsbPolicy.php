<?php

namespace App\Policies;

use App\Role;
use App\Status;
use App\User;
use App\Usb;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsbPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the usb.
     *
     * @param  \App\User $user
     * @param  \App\Usb $usb
     * @return mixed
     */
    public function view(User $user, Usb $usb)
    {
        if ($user->role->id == Role::professor()) {
            if ($usb->status->id == Status::available())
                return true;

            return false;
        } else if ($user->role->id == Role::secretary()) {
            if ($usb->status->id == Status::available() ||
                $usb->status->id == Status::present() ||
                $usb->status->id == Status::absent() ||
                $usb->status->id == Status::used() ||
                $usb->status->id == Status::notInitialized())
                return true;

            return false;
        }
    }

    /**
     * Determine whether the user can delete the usb.
     *
     * @param  \App\User $user
     * @param  \App\Usb $usb
     * @return mixed
     */
    public function delete(User $user, Usb $usb)
    {
        if ($user->role->id == Role::secretary()) {
            if ($usb->status->id == Status::available() ||
                $usb->status->id == Status::present() ||
                $usb->status->id == Status::absent() ||
                $usb->status->id == Status::used() ||
                $usb->status->id == Status::notInitialized())
                return true;

            return false;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the usb.
     *
     * @param  \App\User $user
     * @param  \App\Usb $usb
     * @return mixed
     */
    public function restore(User $user, Usb $usb)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the usb.
     *
     * @param  \App\User $user
     * @param  \App\Usb $usb
     * @return mixed
     */
    public function forceDelete(User $user, Usb $usb)
    {
        //
    }
}
