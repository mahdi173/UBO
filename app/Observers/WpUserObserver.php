<?php

namespace App\Observers;

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
        $log= $this->createLog( "Create", "OK", json_encode($wpUser));      

        $wpUser->logs()->save($log);
    }

    /**
     * Handle the WpUser "updated" event.
     */
    public function updated(WpUser $wpUser): void
    {
        $log= $this->createLog( "Update", "OK", json_encode($wpUser));      

        $wpUser->logs()->save($log);
    }

    /**
     * Handle the WpUser "deleted" event.
     */
    public function deleted(WpUser $wpUser): void
    {
        $log= $this->createLog( "Delete", "OK", json_encode($wpUser));      

        $wpUser->logs()->save($log);
    }

    /**
     * Handle the WpUser "restored" event.
     */
    public function restored(WpUser $wpUser): void
    {
        //
    }

    /**
     * Handle the WpUser "force deleted" event.
     */
    public function forceDeleted(WpUser $wpUser): void
    {
        //
    }
}
