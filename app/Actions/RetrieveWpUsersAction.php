<?php

namespace App\Actions;

use App\Enum\CronStateEnum;
use App\Enum\SitesEnum;
use App\Enum\WpEndpointsEnum;
use App\Models\WpSite;
use App\Models\WpUser;
use App\Repositories\WpRoleRepository;
use App\Repositories\WpSiteRepository;
use App\Repositories\WpUserRepository;
use App\Services\UserSiteService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class RetrieveWpUsersAction
{
    public function __construct(private WpUserRepository $wpUserRepository,
                                private WpSiteRepository $wpSiteRepository,
                                private WpRoleRepository $wpRoleRepository,
                                private UserSiteService $userSiteService
                               ) 
    {}

    public function __invoke()
    {
        $domains = SitesEnum::all();
 
        foreach($domains as $domain){  
            // check if site exist, if not create it
            $wp_site= $this->getOrCreateSite($domain);

            $response = Http::get('http://'.$domain.WpEndpointsEnum::USERS->value);
            
            $users =  $response->json();

            if($response->ok()){
                // Save wp users in database
                $this->saveWpUsers($users, $wp_site);
            }
        }
    }

      /**
     * getOrCreateSite
     *
     * @param  string $domain
     * @return WpSite
     */
    public function getOrCreateSite(string $domain): WpSite{
        $wp_site= $this->wpSiteRepository->getWpSiteByDomain($domain);

        if(!$wp_site){
            //Save wp site in db if it doesn't exist
            $wp_site=  $this->createSite($domain);
        }

        return $wp_site;
    }
    
    /**
     * createSite
     *
     * @param  string $domain
     * @return WpSite
     */
    public function createSite(string $domain): WpSite{
        $new_site=  $this->wpSiteRepository->create([
            "name"=> $domain,
            "domain"=> $domain,
            "type_id"=>1,
            "pole_id"=>1
        ]); 
        
        return $new_site;
    }
    
    /**
     * saveWpUsers
     *
     * @param  array $users
     * @param  WpSite $site
     * @return void
     */
    public function saveWpUsers(array $users, WpSite $site){
        foreach($users as $user){
            $userRoles=[];

            $wp_user= $this->wpUserRepository->getWpUserByEmail($user["email"]);
           
            $roles= $user['roles'];

            // check if wp role exist, if not create it
            $userRoles= $this->getOrCreateRoles($roles);

            if(!$wp_user){
                // If the user doesn't exist, we create it.
                $new_user= $this->createUser($user);

                //Affect sites to wp user
                $this->affectSitesToWpUser($site->id, $new_user, $userRoles); 
            } else{
                // if user does exist we update his sites
                $this->affectSitesToWpUser($site->id, $wp_user, $userRoles);
            }
        }
    }
    
    /**
     * getOrCreateRoles
     *
     * @param  array $roles
     * @return array
     */
    public function getOrCreateRoles(array $roles): array{
        $userRoles= [];
        foreach ($roles as $key => $role) {
            $existed_role= $this->wpRoleRepository->getWpRoleByName($role);

            if(!$existed_role){
                $new_role= $this->wpRoleRepository->create(["name"=> $role]);
                $userRoles[]=$new_role->name;
            }else{
                $userRoles[]=$existed_role->name;
            }
        }

        return $userRoles;
    }
    
    /**
     * createUser
     *
     * @param  mixed $user
     * @return WpUser
     */
    public function createUser($user): WpUser{
        $new_user=$this->wpUserRepository->create([
            "userName"=>$user['username'],
            "firstName"=>$user['firstname'],
            "lastName"=>$user['lastname'],
            "email"=>$user['email']
        ]);

        return $new_user;
    }
    
    /**
     * affectSitesToWpUser
     *
     * @param  int $site_id
     * @param  WpUser $wp_user
     * @param  array $userRoles
     * @return void
     */
    public function affectSitesToWpUser(int $site_id, WpUser $wp_user, array $userRoles){
        $this->userSiteService->attach($site_id, $wp_user->id, [ 'roles'=>json_encode($userRoles), 
                                                                         'username'=>$wp_user->userName,
                                                                         'etat'=> CronStateEnum::FETCH->value,
                                                                         'created_at'=> Carbon::now(),
                                                                         'updated_at'=>Carbon::now()   
                                                                ]);  
    }
}