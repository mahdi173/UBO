<?php

namespace App\Services;

use App\Enum\ActionsEnum;
use App\Models\WpSite;
use App\Models\WpUser;
use App\Repositories\WpRoleRepository;
use App\Repositories\WpSiteRepository;
use App\Repositories\WpUserRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use stdClass;

class WpUserService
{       
    /**
     * __construct
     *
     * @param  WpUserRepository $wpUserRepository
     * @return void 
     */
    public function __construct(private WpUserRepository $wpUserRepository,
                                private WpSiteRepository $wpSiteRepository,
                                private WpRoleRepository $wpRoleRepository,
                                private UserSiteService $userSiteService
                                )
    {
    }
    
    /**
     * storeWpUser
     *
     * @param  array $data
     * @return JsonResponse
     */
    public function storeWpUser(array $data): JsonResponse 
    { 
        $wpUser = $this->wpUserRepository->create($data);
    
        return response()->json($wpUser, 200);
    }
     
    /**
     * affectSites
     *
     * @param  array $data
     * @return JsonResponse
     */
    public function affectSites(array $data): JsonResponse 
    { 
        $wpUser = $this->wpUserRepository->findById($data['id']);
        
        foreach($data['sites'] as $site){
            $this->userSiteService->attach($site["id"],  $wpUser->id, [ 'roles'=> json_encode($site["roles"]), 
                                                                    'username'=> $wpUser->userName,
                                                                    'etat'=> ActionsEnum::CREATE->value,
                                                                    'created_at'=> Carbon::now(),
                                                                    'updated_at'=> Carbon::now()                   
                                                                    ]);
        }
        
        return response()->json(["msg"=>"Sites successfully added to user"], 200);
    }
    
    /**
     * updateWpUser
     *
     * @param  array $data
     * @param  WpUser $wpUser
     * @return JsonResponse
     */
    public function updateWpUser(array $data, WpUser $wpUser): JsonResponse
    {
        $this->wpUserRepository->update($wpUser, $data);

        return response()->json($wpUser, 200);
    }
    
    /**
     * getWpUser
     *
     * @param  mixed $request
     * @param  WpUser $wpUser
     * @return JsonResponse
     */
    public function getWpUser(WpUser $wpUser): JsonResponse
    {
        $response= new stdClass();
        $response= $this->wpUserRepository->getById($wpUser->id);
       
        return response()->json($response);
    }

    /**
     * deleteWpUser
     *
     * @param  WpUser $wpUser
     * @return JsonResponse
     */
    public function deleteWpUser( WpUser $wpUser): JsonResponse
    {
        $this->wpUserRepository->delete($wpUser);

        return response()->json(["msg"=>"Item successfully deleted!"], 200);
    }
    
    /**
     * filter
     *
     * @param  Request $request
     * @return mixed
     */
    public function filter(Request $request): mixed
    {           
        $response= new stdClass();

        $filter= WpUser::filter($request->input('filters'),$request->input('sort'));

        if(!$request->paginate){
            $response->data= $filter->get();
        }else{
            $response= $filter->paginate($request->paginate);
        }

        return $response;
    }
    
    /**
     * getAllWpUsers
     *
     * @return void
     */
    public function getAllWpUsers()
    {
        $sites=[["name"=>"Mystery Blog", "domain"=>"http://mysteryblog.com"], 
                ["name"=>"Laracast", "domain"=>"http://ubolaracast.com"]];
        
        $key=  config('app.key');

        $data= [
            "username"=> "kei",
            "password"=> "Rm9c)ii@pYc77bpXxH",
            "key"=> $key
        ];

        Http::accept('application/json')->post('http://mysteryblog.com/wp-json/wp/v2/key', $data);
        
        $headers = [
            'X-Encryption-key' =>$key,
        ];

        foreach($sites as $site){            
            // check if site exist, if not create it
            $wp_site= $this->getOrCreateSite($site);

            $response = Http::withHeaders($headers)->get($wp_site->domain.'/wp-json/wp/v2/wp-users');
            
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
     * @param  mixed $site
     * @return WpSite
     */
    public function getOrCreateSite(mixed $site): WpSite{
        $wp_site= $this->wpSiteRepository->getWpSiteByDomain($site["domain"]);

        if(!$wp_site){
            //Save wp site in db if it doesn't exist
            $wp_site=  $this->createSite($site);
        }

        return $wp_site;
    }
    
    /**
     * createSite
     *
     * @param  mixed $site
     * @return WpSite
     */
    public function createSite($site): WpSite{
        $new_site=  $this->wpSiteRepository->create([
            "name"=> $site["name"],
            "domain"=> $site["domain"],
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
                //If user doent only have subscriber as role or if it have other roles beside it we save this user in db
                if(count($roles)==1 && $roles[0]!='subscriber')
                {
                    $new_user= $this->createUser($user);
                    //Affect sites to wp user
                    $this->affectSitesToWpUser($site->id, $new_user, $userRoles);
                }else if (count($roles)>1){ 
                    $new_user= $this->createUser($user);
                    $this->affectSitesToWpUser($site->id, $new_user, $userRoles);
                }   
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
                                                                         'etat'=> ActionsEnum::FETCH->value,
                                                                         'created_at'=> Carbon::now(),
                                                                         'updated_at'=>Carbon::now()   
                                                                ]);  
    }
}