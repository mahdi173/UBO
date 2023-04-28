<?php

namespace App\Traits;

use App\Models\Log;

trait CreateLogInstanceTrait
{
    public function createLog(string $action, string $status, mixed $json): Log{
        $log= new Log();
        $log->user_id= auth()->user()->id;
        $log->user_name= auth()->user()->userName;
        $log->action= $action;
        $log->status= $status;
        $log->json_detail= $json;

        return $log;
    }
}