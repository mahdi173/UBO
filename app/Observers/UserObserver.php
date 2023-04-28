<?php

namespace App\Observers;

use App\Models\User;
use App\Traits\CreateLogInstanceTrait;

class UserObserver
{
    use CreateLogInstanceTrait;

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $log= $this->createLog( "Create", "OK", json_encode($user));

        $user->logs()->save($log);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $log= $this->createLog( "Update", "OK", json_encode($user));

        $user->logs()->save($log);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $log= $this->createLog( "Delete", "OK", json_encode($user));

        $user->logs()->save($log);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
