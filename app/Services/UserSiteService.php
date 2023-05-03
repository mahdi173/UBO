<?php

namespace App\Services;

use App\Models\WpSite;
use App\Models\WpUser;

class UserSiteService
{    
    public function attach($id, mixed $target, array $data)
    {
        if($target instanceof WpUser){
            $target->sites()->attach($id, $data);
        }else if($target instanceof WpSite){
            $target->users()->attach($id, $data);
        }
    }
}