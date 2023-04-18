<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\CheckIfUserIsAdminTrait;
use Illuminate\Auth\Access\Response;

class WpSitePolicy
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
    public function createWpSite(User $user): Response
    {
        return $this->checkIfUserIsAdmin($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateWpSite(User $user): Response
    {
        return $this->checkIfUserIsAdmin($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteWpSite(User $user): Response
    {
        return $this->checkIfUserIsAdmin($user);
    }
}
