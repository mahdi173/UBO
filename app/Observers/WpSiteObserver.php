<?php

namespace App\Observers;

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
        $log= $this->createLog( "Create", "OK", json_encode($wpSite));      

        $wpSite->logs()->save($log);
    }

    /**
     * Handle the WpSite "updated" event.
     */
    public function updated(WpSite $wpSite): void
    {
        $log= $this->createLog( "Update", "OK", json_encode($wpSite));

        $wpSite->logs()->save($log);
    }

    /**
     * Handle the WpSite "deleted" event.
     */
    public function deleted(WpSite $wpSite): void
    {
        $log= $this->createLog( "Delete", "OK", json_encode($wpSite));

        $wpSite->logs()->save($log);
    }

    /**
     * Handle the WpSite "restored" event.
     */
    public function restored(WpSite $wpSite): void
    {
        //
    }

    /**
     * Handle the WpSite "force deleted" event.
     */
    public function forceDeleted(WpSite $wpSite): void
    {
        //
    }
}
