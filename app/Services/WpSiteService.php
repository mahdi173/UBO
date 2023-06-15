<?php

namespace App\Services;

use App\Enum\ActionsEnum;
use App\Models\WpSite;
use App\Repositories\WpSiteRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use stdClass;

class WpSiteService
{   
     /**
     * __construct
     *
     * @param  WpSiteRepository $wpSiteRepository
     * @return void
     */
    public function __construct(private WpSiteRepository $wpSiteRepository, private UserSiteService $userSiteService)
    {
    }
    
    /**
     * storeWpSite
     *
     * @param  array $data
     * @return JsonResponse
     */
    public function storeWpSite(array $data): JsonResponse
    {
        $wpSite= $this->wpSiteRepository->create($data);
        return response()->json($wpSite);
    }
     
    /**
     * affectUsers
     *
     * @param  array $data
     * @return JsonResponse
     */
    public function affectUsers(array $data): JsonResponse 
    { 
        $wpSite = $this->wpSiteRepository->findById($data['id']);

        $username="";
        if(isset($user["username"])){
            $username= $user["username"];
        }

        foreach($data['users'] as $user){
            $this->userSiteService->attach($wpSite->id, $user["id"], [ 'roles'=> json_encode($user["roles"]), 
                                                                    'username'=> $username,
                                                                    'etat'=> ActionsEnum::CREATE->value,
                                                                    'created_at'=> Carbon::now(),
                                                                    'updated_at'=> Carbon::now()                   
                                                                    ]);
        }
        
        return response()->json(["message"=>"Users successfully added to site"]);
    }

    /**
     * updateWpSite
     *
     * @param  array $data
     * @param  WpSite $wpSite
     * @return JsonResponse
     */
    public function updateWpSite(array $data, WpSite $wpSite): JsonResponse
    {
        $this->wpSiteRepository->update($wpSite, $data);
        return response()->json($wpSite, 200);
    }
    
    /**
     * deleteWpSite
     *
     * @param  WpSite $wpSite
     * @return JsonResponse
     */
    public function deleteWpSite( WpSite $wpSite): JsonResponse
    {
        $this->wpSiteRepository->delete($wpSite);

        $userIds= $wpSite->users()->pluck('wp_users.id')->toArray();

        foreach($userIds as $id){
            $response= $this->userSiteService->detach($wpSite->id, $id);
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

        $filter= WpSite::filter($request->input('filters'),$request->input('sort'));

        if(!$request->paginate){
            $response->data= $filter->get();
        }else{
            $response= $filter->paginate($request->paginate);
        }

        return $response;
    }

    public function showUsers(WpSite $wpSite)
    {
         return $this->wpSiteRepository->showUsers( $wpSite);
        
    }    
    /**
     * showDeletedData
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function showDeletedData(Request $request): mixed{
        $response= new stdClass();

        $deletedRecords=WpSite::onlyTrashed()->filter(

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
        
        $record = WpSite::withTrashed()->findOrFail($id);
        $record->restore();
        return response()->json([
            'message' => 'Site restored successfully',
            'data' => $record
        ]);
}
}