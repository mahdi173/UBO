<?php

namespace App\Traits;

use Illuminate\Auth\Access\Response;

trait CheckIfUserIsAdminTrait
{
    public function  checkIfUserIsAdmin($user): Response{
        return $user->isAdmin()
            ? Response::allow()
            : Response::denyWithStatus(403);
    }
}