<?php

namespace App\Traits;

use App\Models\Log;

trait CreateLogInstanceTrait
{
    public function createLog(string $action, string $status, mixed $json): Log{
        $log= new Log();
        if(auth()->user()){
            $log->user_id= auth()->user()->id;
            $log->user_name= auth()->user()->userName;
        }else{
            $log->user_id= 1;
            $log->user_name= "System";
        }
        $log->action= $action;
        $log->status= $status;
        $log->json_detail= $json;

        return $log;
    }
}