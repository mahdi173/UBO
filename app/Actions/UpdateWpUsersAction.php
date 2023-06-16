<?php

namespace App\Actions;

use App\Enum\ActionsEnum;
use App\Enum\CronStateEnum;
use App\Enum\StatusEnum;
use App\Enum\WpEndpointsEnum;
use App\Models\UserSite;
use App\Models\WpSite;
use App\Traits\CreateLogInstanceTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UpdateWpUsersAction
{
    use CreateLogInstanceTrait;

    public function __invoke()
    {        
        $userSites = DB::table('user_site')
                        ->join('wp_users', 'user_site.wp_user_id', '=', 'wp_users.id')
                        ->select('user_site.id', 'wp_user_id', 'wp_site_id', 'roles', 'wp_users.email', 'wp_users.firstName', 'wp_users.lastName')
                        ->where('user_site.etat', CronStateEnum::ToUpdate->value)
                        ->get()
                        ->groupBy('wp_site_id');

        foreach ($userSites as $siteId => $data) {
            $site = WpSite::find($siteId);
            $domain = $site->domain;

            $this->sendToUpdateUsers($data, $domain);
        }
    }
    
    /**
     * sendToUpdateUsers
     *
     * @param  mixed $data
     * @param  string $domain
     * @return void
     */
    public function sendToUpdateUsers(mixed $data, string $domain): void {
        foreach($data as $userSite){
            $userData= $this->makeUserData($userSite);

            $response=  Http::accept('application/json')
                             ->put('http://'.$domain.WpEndpointsEnum::USERS->value, $userData);

            $existedUserSite=  UserSite::find($userSite->id);

            if($response->ok()){
                UserSite::where('wp_user_id',$userSite->wp_user_id)
                ->where('wp_site_id', $userSite->wp_site_id)->update(['etat'=> CronStateEnum::Active->value]);

                $this->registreLog(ActionsEnum::UPDATE->value, StatusEnum::SUCCESS->value, json_encode($userSite), $existedUserSite);
            }else{
                $this->registreLog(ActionsEnum::UPDATE->value, StatusEnum::DANGER->value, json_encode($userSite), $existedUserSite);
            }
        }
    }
    
    /**
     * registreLog
     *
     * @param  string $action
     * @param  string $status
     * @param  mixed $data
     * @param  UserSite $target
     * @return void
     */
    public function registreLog(string $action, string $status, mixed $data, UserSite $target):void 
    {
        $log= $this->createLog($action, $status, $data);
        $target->logs()->save($log);
    }
    
    /**
     * makeUserData
     *
     * @param  mixed $data
     * @return array
     */
    public function makeUserData(mixed $data): array{
        return ["roles"=>$data->roles, 
                "email"=>$data->email, 
                "firstname"=>$data->firstName, 
                "lastname"=>$data->lastName
                ];
    }
}