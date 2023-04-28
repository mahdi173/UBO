<?php

namespace App\Observers;

use App\Enum\ActionsEnum;
use App\Enum\StatusEnum;
use App\Models\WpUser;
use App\Traits\CreateLogInstanceTrait;

class WpUserObserver
{
    use CreateLogInstanceTrait;

    /**
     * Handle the WpUser "created" event.
     */
    public function created(WpUser $wpUser): void
    {
        $log= $this->createLog( ActionsEnum::CREATE->value,  StatusEnum::SUCCESS->value, json_encode($wpUser));      

        $wpUser->logs()->save($log);
    }

    /**
     * Handle the WpUser "updated" event.
     */
    public function updated(WpUser $wpUser): void
    {
        $log= $this->createLog( ActionsEnum::UPDATE->value,  StatusEnum::SUCCESS->value, json_encode($wpUser));      

        $wpUser->logs()->save($log);
    }

    /**
     * Handle the WpUser "deleted" event.
     */
    public function deleted(WpUser $wpUser): void
    {
        $log= $this->createLog( ActionsEnum::DELETE->value,  StatusEnum::SUCCESS->value, json_encode($wpUser));      

        $wpUser->logs()->save($log);
    }
}