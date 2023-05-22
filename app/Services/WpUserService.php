<?php

namespace App\Services;

use App\Enum\ActionsEnum;
use App\Models\WpUser;
use App\Repositories\WpUserRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
}