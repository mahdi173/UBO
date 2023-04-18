<?php

namespace App\Services;

use App\Models\WpUser;
use App\Repositories\WpRoleRepository;
use App\Repositories\WpSiteRepository;
use App\Repositories\WpUserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WpUserService
{       
    /**
     * __construct
     *
     * @param  WpUserRepository $wpUserRepository
     * @return void
     */
    public function __construct(    private WpUserRepository $wpUserRepository,
                                    private WpSiteRepository $wpSiteRepository,
                                    private WpRoleRepository $wpRoleRepository
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
        $userDetails= $this->wpUserRepository->getById($wpUser->id);

        return response()->json($userDetails);
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
    public function getAllWpUsers(){
        //$username="kei";
        //$password= 'GYO1&rD$FE1!Oc6Hy@';
        //withBasicAuth($username, $password)

        $response = Http::get('http://ubowordpress.com/wp-json/wp/v2/wp-users');
        
        $users = json_decode($response->json());
        
        foreach($users as $user){

            $userRoles=$user->roles;

            if ($userRoles){
                foreach($userRoles as $userRole){
                    $role= $this->wpRoleRepository->getWpRoleByName($userRole);
    
                    if(!$role){
                        $this->wpRoleRepository->create(["name"=> $userRole]);
                    }
                }
            }

            $userSites=$user->sites;
            
            foreach($userSites as $userSite){
                $site= $this->wpSiteRepository->getWpSiteByName($userSite->blogname);

                if(!$site){
                    $this->wpSiteRepository->create([
                        "name"=> $userSite->blogname,
                        "domain"=> $userSite->domain,
                        "type_id"=>1,
                        "pole_id"=>1
                    ]);                   
                }
            }

            $userDb= $this->wpUserRepository->getWpUserByUsername($user->username);
            
            if(!$userDb)
            {
                $this->wpUserRepository->create([
                    "userName"=>$user->username,
                    "firstName"=>$user->firstname,
                    "lastName"=>$user->lastname,
                    "email"=>$user->email,
                    "password"=> $user->pass
                ]);
            }
        }
    }
}