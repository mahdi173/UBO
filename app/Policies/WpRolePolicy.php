<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\CheckIfUserIsAdminTrait;
use Illuminate\Auth\Access\Response;

class WpRolePolicy
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
    public function createWpRole(User $user): Response
    {
        return $this->checkIfUserIsAdmin($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateWpRole(User $user): Response
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
