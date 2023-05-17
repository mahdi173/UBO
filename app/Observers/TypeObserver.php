<?php

namespace App\Observers;

use App\Models\Type;
use App\Enum\StatusEnum;
use App\Enum\ActionsEnum;
use App\Traits\CreateLogInstanceTrait;

class TypeObserver
{
    use CreateLogInstanceTrait;
    /**
     * Handle the Type "created" event.
     */
    public function created(Type $type): void
    {
        $log= $this->createLog( ActionsEnum::CREATE->value, StatusEnum::SUCCESS->value, json_encode($type));      
        $type->logs()->save($log);
    }

    /**
     * Handle the Type "updated" event.
     */
    public function updated(Type $type): void
    {
        $log= $this->createLog( ActionsEnum::UPDATE->value,  StatusEnum::SUCCESS->value, json_encode($type));
        $type->logs()->save($log);
    }

    /**
     * Handle the Type "deleted" event.
     */
    public function deleted(Type $type): void
    {
        $log= $this->createLog( ActionsEnum::DELETE->value,  StatusEnum::SUCCESS->value, json_encode($type));
        $type->logs()->save($log);
    }

   
}
