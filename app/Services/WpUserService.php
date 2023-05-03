<?php

namespace App\Services;

use App\Enum\ActionsEnum;
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
    public function storeWpUser(array $data, array $sites): JsonResponse 
    { 
        $wpUser = $this->wpUserRepository->create($data);
        
        foreach($sites as $site){
            $this->userSiteService->attach($site["id"],  $wpUser, [ 'roles'=> json_encode($site["roles"]), 
                                                                    'username'=> $wpUser->userName,
                                                                    'etat'=> ActionsEnum::CREATE->value,
                                                                    'created_at'=> Carbon::now(),
                                                                    'updated_at'=> Carbon::now()                   
                                                                    ]);
        }

        return response()->json($wpUser, 200);
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
     * @return JsonResponse
     */
    public function filter(Request $request): JsonResponse
    {           
        $results= WpUser::filter($request->input('filters'),$request->input('sort') ,$request->paginate);

        if(!$request->paginate){
            return  response()->json(["data"=> $results->get()]);
        }else{
            return response()->json($results);
        }
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
       
        foreach($sites as $site){            
            $keyResponse = Http::accept('application/json')->get($site["domain"].'/wp-json/wp/v2/key');
            $key= $keyResponse->json();   
    
            $headers = [
                'X-My-Static-Key' =>$key,
            ];

            $response = Http::withHeaders($headers)->get($site["domain"].'/wp-json/wp/v2/wp-users');

            $users =  $response->json();

            $wp_site= $this->wpSiteRepository->getWpSiteByDomain($site["domain"]);

            if(!$wp_site){
                $wp_site=  $this->wpSiteRepository->create([
                    "name"=> $site["name"],
                    "domain"=> $site["domain"],
                    "type_id"=>1,
                    "pole_id"=>1
                ]);                
            }

            foreach($users as $user){
                $userRoles=[];

                $wp_user= $this->wpUserRepository->getWpUserByEmail($user["email"]);
                
                if(!$wp_user)
                {
                   $wp_user=$this->wpUserRepository->create([
                        "userName"=>$user['username'],
                        "firstName"=>$user['firstname'],
                        "lastName"=>$user['lastname'],
                        "email"=>$user['email'],
                        "password"=> $user['pass']
                    ]);
                }

                $roles= $user['roles'];

                foreach ($roles as $key => $role) {
                    $role= $this->wpRoleRepository->getWpRoleByName($role);

                    if(!$role){
                        $role= $this->wpRoleRepository->create(["name"=> $role]);
                    }

                    $userRoles[]=$role->name;
                }

                $this->userSiteService->attach($wp_site->id, $wp_user, [ 'roles'=>json_encode($userRoles), 
                                                                         'username'=>$wp_user->userName,
                                                                         'etat'=> ActionsEnum::CREATE->value,
                                                                         'created_at'=> Carbon::now(),
                                                                         'updated_at'=>Carbon::now()   
                                                                        ]);           
            }

        }
    }
}