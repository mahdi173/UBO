<?php

namespace App\Services;

use App\Enum\CronStateEnum;
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

    /**
     * detach
     *
     * @param  int $site_id
     * @param  int $user_id
     * @return bool
     */
    public function detach(int $site_id, int $user_id): bool
    {
        $relation_exist= UserSite::where('wp_user_id', $user_id)
        ->where('wp_site_id', $site_id)->first();

        $data= ['etat'=> CronStateEnum::ToDelete->value];

        if($relation_exist){
            UserSite::where('wp_user_id', $user_id)
            ->where('wp_site_id', $site_id)->update($data);

            return true;
        }     

        return false;
    }

    public function sync(int $target, array $data)
    {
        foreach ($data as $element) {
            $syncData=  ["roles"=> json_encode($element['roles']), "etat"=> CronStateEnum::ToUpdate->value];
           
            $relation_exist= UserSite::where('wp_user_id', $element['id'])
            ->where('wp_site_id', $target)->first();

            if($relation_exist){
                UserSite::where('wp_user_id', $element['id'])
                ->where('wp_site_id', $target)->update($syncData);
            }else{
                UserSite::where('wp_user_id', $target)
                ->where('wp_site_id', $element['id'])->update($syncData);
            }
        }
    }
}