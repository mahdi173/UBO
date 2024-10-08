<?php

namespace App\Actions;

use App\Enum\ActionsEnum;
use App\Enum\CronStateEnum;
use App\Enum\StatusEnum;
use App\Enum\WpEndpointsEnum;
use App\Jobs\SendMailJob;
use App\Mail\SendPwdWpUser;
use App\Models\UserSite;
use App\Models\WpSite;
use App\Traits\CreateLogInstanceTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SendWpUsersAction
{
    use CreateLogInstanceTrait;

    public function __invoke()
    { 
        $userSites = DB::table('user_site')
                        ->join('wp_users', 'user_site.wp_user_id', '=', 'wp_users.id')
                        ->select('user_site.id', 'wp_user_id', 'wp_site_id', 'roles', 'wp_users.email', 'wp_users.userName', 'wp_users.firstName', 'wp_users.lastName')
                        ->where('user_site.etat', CronStateEnum::Create->value)
                        ->get()
                        ->groupBy('wp_site_id');

        foreach ($userSites as $siteId => $data) {
            $site = WpSite::find($siteId);
            $domain = $site->domain;
            
            $this->sendToCreateUsers($data, $domain);
        }
    }

    public function sendToCreateUsers(mixed $data, string $domain){
        foreach($data as $userSite){
            $userData= $this->makeUserData($userSite);

            $response=  Http::accept('application/json')
            ->post('http://'.$domain.WpEndpointsEnum::USERS->value, $userData);

            $existedUserSite=  UserSite::find($userSite->id);

            if($response->ok()){ 
                $mail= new SendPwdWpUser($userData['email'], $userData['password'], $domain);
                SendMailJob::dispatch($mail);

                UserSite::where('wp_user_id',$userSite->wp_user_id)
                ->where('wp_site_id', $userSite->wp_site_id)->update(['etat'=> CronStateEnum::Active->value]);

                $this->registreLog(ActionsEnum::CREATE->value, StatusEnum::SUCCESS->value, json_encode($userSite), $existedUserSite);
            }else{
                $this->registreLog(ActionsEnum::CREATE->value, StatusEnum::DANGER->value, json_encode($userSite), $existedUserSite);
            }
        }
    }

    public function registreLog(string $action, string $status, mixed $data, UserSite $target):void 
    {
        $log= $this->createLog($action, $status, $data);
        $target->logs()->save($log);
    }

    public function makeUserData($data){
        return ["roles"=>json_decode($data->roles), 
                "email"=>$data->email, 
                "username"=>$data->userName, 
                "firstname"=>$data->firstName, 
                "lastname"=>$data->lastName,
                "password"=> Str::random(8)
                ];
    }
}