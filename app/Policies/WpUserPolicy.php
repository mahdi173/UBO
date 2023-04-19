<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\CheckIfUserIsAdminTrait;
use Illuminate\Auth\Access\Response;

class WpUserPolicy
{
    use CheckIfUserIsAdminTrait;
    
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }
    
    /**
     * Determine whether the user can create models.
     */
    public function createWpUser(User $user): Response
    {
        return $this->checkIfUserIsAdmin($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateWpUser(User $user): Response
    {
        return $this->checkIfUserIsAdmin($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return $this->checkIfUserIsAdmin($user);
    }
}
