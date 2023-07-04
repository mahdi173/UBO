<?php

namespace App\Services;

use App\Enum\CronStateEnum;
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
        $existedUser= $this->wpUserRepository->getWpUserByEmail($data["email"]);
        
        if($existedUser){
            $data["deleted_at"]= null; 
            unset($data["email"]);
            $this->wpUserRepository->update( $existedUser, $data);
            $wpUser =  $existedUser;
        }else{
            $wpUser = $this->wpUserRepository->create($data);
        }
    
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
                                                                    'etat'=> CronStateEnum::Create->value,
                                                                    'created_at'=> Carbon::now(),
                                                                    'updated_at'=> Carbon::now()                   
                                                                    ]);
        }
        
        return response()->json(["message"=>"Sites successfully added to user"], 200);
    }
    
    /**
     * updateWpUser
     *
     * @param  array $data
     * @param  WpUser $wpUser
     * @param  array $sites
     * @return JsonResponse
     */
    public function updateWpUser(array $data, WpUser $wpUser, array $sites): JsonResponse
    {
        $this->wpUserRepository->update($wpUser, $data);

        $this->userSiteService->sync($wpUser->id, $sites);

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

        $siteIds= $wpUser->sites()->pluck('wp_sites.id')->toArray();
     
        foreach($siteIds as $id){
            $response= $this->userSiteService->detach($id, $wpUser->id);
            if(!$response){
                return response()->json(["message"=>"User or site doesn't exist!"], 404);
            }
        }   

        return response()->json(["message"=>"User successfully deleted!"]);
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
     * showDeletedData
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function showDeletedData(Request $request): mixed{
        $response= new stdClass();

        $deletedRecords=WpUser::onlyTrashed()->filter(

            $request->input('filters'),
            $request->input('sort')
            );
           if(!$request->paginate){
            $response->data= $deletedRecords->get();

           }else{
            $response= $deletedRecords->paginate($request->paginate);
           }

           return $response;
    }
    
      /**
     * restore
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function restore (string $id): JsonResponse{
        
        $record = WpUser::withTrashed()->findOrFail($id);
        $record->restore();
        return response()->json([
            'message' => 'User restored successfully',
            'data' => $record
        ]);
    }
    
    /**
     * deleteSite
     *
     * @param  int $user_id
     * @param  int $site_id
     * @return bool
     */
    public function deleteSite(int $user_id, int $site_id): bool{
       return $this->userSiteService->detach($site_id, $user_id);
    }

     /**
     * count WP Users
     *
     * @return void
     */
    public function count()
    {
         return $wpUsers= WpUser::count();
    }
}