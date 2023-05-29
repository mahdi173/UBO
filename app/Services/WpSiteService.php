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
        
        foreach($data['users'] as $user){
            $this->userSiteService->attach($wpSite->id, $user["id"], [ 'roles'=> json_encode($user["roles"]), 
                                                                    'username'=> $user["username"],
                                                                    'etat'=> ActionsEnum::CREATE->value,
                                                                    'created_at'=> Carbon::now(),
                                                                    'updated_at'=> Carbon::now()                   
                                                                    ]);
        }
        
        return response()->json(["msg"=>"Users successfully added to site"], 200);
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