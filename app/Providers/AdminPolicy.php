<?php

namespace App\Providers;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

class AdminPolicy
{
    use HandlesAuthorization;

    public function isSuperAdmin(User $user)
    {
        if(!is_null($user->getRoles)) {
            if($user->getRoles->id ==3){
                return true;
            }
        }
        return false;
    }

    public function isAdmin(User $user)
    {
        if(!is_null($user->getRoles)) {
            if($user->getRoles->id ==2){
                return true;
            }
        }
        return false;
    }

    public function hasAdminRight(User $user)
    {
        if(!is_null($user->getRoles)) {
            if($user->getRoles->id ==2 || $user->getRoles->id ==3 ){
                return true;
            }
        }
        return false;
    }

//    public function before($user, $ability)
//    {
//        return true;
//        if ($user->isSuperAdmin()) {
//            return true;
//        }
//    }
}
