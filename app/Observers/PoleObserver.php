<?php

namespace App\Observers;

use App\Models\Pole;
use App\Enum\StatusEnum;
use App\Enum\ActionsEnum;
use App\Traits\CreateLogInstanceTrait;
use Illuminate\Support\Facades\Validator;

class PoleObserver
{
    use CreateLogInstanceTrait;
    /**
     * Handle the Pole "created" event.
     */
    public function created(Pole $pole): void
    {
        $log= $this->createLog( ActionsEnum::CREATE->value,StatusEnum::SUCCESS->value, json_encode($pole));      
        $pole->logs()->save($log);
    }

    /**
     * Handle the Pole "updated" event.
     */
    public function updated(Pole $pole): void
    {
        $log= $this->createLog( ActionsEnum::UPDATE->value,  StatusEnum::SUCCESS->value, json_encode($pole));
        $pole->logs()->save($log);
    }

    /**
     * Handle the Pole "deleted" event.
     */
    public function deleted(Pole $pole): void
    {
        $log= $this->createLog( ActionsEnum::DELETE->value,  StatusEnum::SUCCESS->value, json_encode($pole));
        $pole->logs()->save($log);
    }

}
