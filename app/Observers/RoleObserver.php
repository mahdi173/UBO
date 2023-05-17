<?php

namespace App\Observers;

use App\Models\Role;
use App\Enum\StatusEnum;
use App\Enum\ActionsEnum;
use App\Traits\CreateLogInstanceTrait;
class RoleObserver
{
    use CreateLogInstanceTrait;
    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
       
        $log= $this->createLog( ActionsEnum::CREATE->value,StatusEnum::SUCCESS->value, json_encode($role));      
        $role->logs()->save($log);
    }

    /**
     * Handle the Role "updated" event.
     */
    public function updated(Role $role): void
    {
        $log= $this->createLog( ActionsEnum::UPDATE->value,  StatusEnum::SUCCESS->value, json_encode($role));
        $role->logs()->save($log);
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        $log= $this->createLog( ActionsEnum::DELETE->value,  StatusEnum::SUCCESS->value, json_encode($role));
        $role->logs()->save($log);
    }

   
}
