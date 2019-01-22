<?php

namespace App\Policies;

use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the "reserved from" column in the table
     *
     * @param User $user
     * @return bool
     */
//    public function viewReservedFrom(User $user){
//
//        if ($user->role->id == Role::secretary())
//            return true;
//
//        return false;
//    }

    /**
     * Determine whether the user can see the delete usb button
     *
     * @param User $user
     * @return bool
     */
    public function viewDeleteUsb(User $user){

        if ($user->role->id == Role::secretary())
            return true;

        return false;
    }

    /**
     * Determine whether the user can see the "Action" column at the /home address
     *
     * @param User $user
     * @return bool
     */
//    public function viewActionColumn(User $user){
//        if($user->role->id == Role::secretary())
//            return true;
//
//        return false;
//    }

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
}
