<?php

namespace App\Observers;

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
        $log= $this->createLog( "Create", "OK", json_encode($wpRole));

        $wpRole->logs()->save($log);
    }

    /**
     * Handle the WpRole "updated" event.
     */
    public function updated(WpRole $wpRole): void
    {
        $log= $this->createLog( "Update", "OK", json_encode($wpRole));

        $wpRole->logs()->save($log);
    }

    /**
     * Handle the WpRole "deleted" event.
     */
    public function deleted(WpRole $wpRole): void
    {
        $log= $this->createLog( "Delete", "OK", json_encode($wpRole));

        $wpRole->logs()->save($log);
    }

    /**
     * Handle the WpRole "restored" event.
     */
    public function restored(WpRole $wpRole): void
    {
        //
    }

    /**
     * Handle the WpRole "force deleted" event.
     */
    public function forceDeleted(WpRole $wpRole): void
    {
        //
    }
}
