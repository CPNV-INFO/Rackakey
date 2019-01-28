<?php

namespace App\Policies;

use App\Role;
use App\Status;
use App\User;
use App\Usb;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

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
        // Only admin can restore a key but he already can do everything so we put nothing here
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
        return false;
    }

    /**
     * Determine whether the user can see the delete usb button
     *
     * @param User $user
     * @param Usb $usb
     * @return bool
     */
    public function viewDeleteUsbButton(User $user){

        if ($user->role->id == Role::secretary())
            return true;

        return false;
    }

    /**
     * Determine whether the user can the soft deletes. Here we don't put anything in it because only
     * admin can see them (and he's already granted for all policies in \Providers\AuthServiceProvider.php)
     *
     * @param User $user
     * @return bool
     */
    public function viewSoftDelete(User $user){
        return false;
    }

    /**
     * Determine whether the user can see the download button for the usb
     *
     * @param User $user
     * @param Usb $usb
     * @return bool
     */
    public function viewDownloadUsbDataButton(User $user, Usb $usb){

        if ($user->role->id == Role::secretary())
            return true;

        // If the usb shown is actually the one that the user reseved
        if($usb->reservation->count() > 0){
            if($usb->reservation->first()->user_id == Auth::id())
                return true;
        }

        return false;
    }


    /**
     * Determine whether the user can see the explore button for the usb
     *
     * @param User $user
     * @param Usb $usb
     * @return bool
     */
    public function viewExploreUsbButton(User $user, Usb $usb){

        if ($user->role->id == Role::secretary())
            return true;

        // If the usb shown is actually the one that the user reseved
        if($usb->reservation->count() > 0){
            if($usb->reservation->first()->user_id == Auth::id())
                return true;
        }

        return false;
    }

    /**
     * Determine whether the user can see the initialize button for the usb
     *
     * @param User $user
     * @param Usb $usb
     * @return bool
     */
    public function viewInitializeUsbButton(User $user, Usb $usb){

        if ($user->role->id == Role::secretary())
            return true;

        return false;
    }

}
