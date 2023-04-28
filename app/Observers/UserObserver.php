<?php

namespace App\Observers;

use App\Enum\ActionsEnum;
use App\Enum\StatusEnum;
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
        $log= $this->createLog( ActionsEnum::CREATE->value, StatusEnum::SUCCESS->value, json_encode($user));

        $user->logs()->save($log);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $log= $this->createLog( ActionsEnum::UPDATE->value, StatusEnum::SUCCESS->value, json_encode($user));

        $user->logs()->save($log);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $log= $this->createLog( ActionsEnum::DELETE->value, StatusEnum::SUCCESS->value, json_encode($user));

        $user->logs()->save($log);
    }
}