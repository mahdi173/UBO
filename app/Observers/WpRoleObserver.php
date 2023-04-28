<?php

namespace App\Observers;

use App\Enum\ActionsEnum;
use App\Enum\StatusEnum;
use App\Models\WpRole;
use App\Traits\CreateLogInstanceTrait;

class WpRoleObserver
{
    use CreateLogInstanceTrait;

    /**
     * Handle the WpRole "created" event.
     */
    public function created(WpRole $wpRole): void
    {
        $log= $this->createLog( ActionsEnum::CREATE->value,  StatusEnum::SUCCESS->value, json_encode($wpRole));

        $wpRole->logs()->save($log);
    }

    /**
     * Handle the WpRole "updated" event.
     */
    public function updated(WpRole $wpRole): void
    {
        $log= $this->createLog( ActionsEnum::UPDATE->value,  StatusEnum::SUCCESS->value, json_encode($wpRole));

        $wpRole->logs()->save($log);
    }

    /**
     * Handle the WpRole "deleted" event.
     */
    public function deleted(WpRole $wpRole): void
    {
        $log= $this->createLog( ActionsEnum::DELETE->value,  StatusEnum::SUCCESS->value, json_encode($wpRole));

        $wpRole->logs()->save($log);
    }
}