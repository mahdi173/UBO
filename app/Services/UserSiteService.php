<?php

namespace App\Services;

use App\Models\UserSite;
use App\Models\WpSite;
use App\Models\WpUser;

class UserSiteService
{    
    public function attach($id, mixed $target, array $data)
    {
        if($target instanceof WpUser){
           $relation_exist= UserSite::where('wp_user_id', $target->id)
                               ->where('wp_site_id', $id)->first();
           
            if($relation_exist){
                UserSite::where('wp_user_id', $target->id)
                ->where('wp_site_id', $id)->update($data);
            }else{
                $target->sites()->attach($id, $data);
            }
        }else if($target instanceof WpSite){
            $target->users()->attach($id, $data);
        }
    }
}