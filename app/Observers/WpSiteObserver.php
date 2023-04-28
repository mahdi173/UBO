<?php

namespace App\Observers;

use App\Enum\ActionsEnum;
use App\Enum\StatusEnum;
use App\Models\WpSite;
use App\Traits\CreateLogInstanceTrait;

class WpSiteObserver
{
    use CreateLogInstanceTrait;

    /**
     * Handle the WpSite "created" event.
     */
    public function created(WpSite $wpSite): void
    {
        $log= $this->createLog( ActionsEnum::CREATE->value,  StatusEnum::SUCCESS->value, json_encode($wpSite));      

        $wpSite->logs()->save($log);
    }

    /**
     * Handle the WpSite "updated" event.
     */
    public function updated(WpSite $wpSite): void
    {
        $log= $this->createLog( ActionsEnum::UPDATE->value,  StatusEnum::SUCCESS->value, json_encode($wpSite));

        $wpSite->logs()->save($log);
    }

    /**
     * Handle the WpSite "deleted" event.
     */
    public function deleted(WpSite $wpSite): void
    {
        $log= $this->createLog( ActionsEnum::DELETE->value,  StatusEnum::SUCCESS->value, json_encode($wpSite));

        $wpSite->logs()->save($log);
    }
}