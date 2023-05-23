<?php

namespace App\Services;

use App\Models\UserSite;
use App\Models\WpUser;

class UserSiteService
{    
    public function attach($site_id, $user_id, array $data)
    {
        $relation_exist= UserSite::where('wp_user_id', $user_id)
                               ->where('wp_site_id', $site_id)->first();
           
        if($relation_exist){
            UserSite::where('wp_user_id', $user_id)
            ->where('wp_site_id', $site_id)->update($data);
        }else{
            $user= WpUser::findOrFail($user_id);
            $user->sites()->attach($site_id, $data);
        }
    }
}