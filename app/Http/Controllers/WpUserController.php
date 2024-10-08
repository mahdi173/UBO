<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWpUserRequest;
use App\Http\Requests\UpdateWpUserRequest;
use App\Models\WpUser;
use App\Services\WpUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WpUserController extends Controller
{
     /**
     * __construct
     *
     * @param  WpUserService $wpUserService
     * @return void
     */
    public function __construct(private WpUserService  $wpUserService)
    {
    }
    
    /**
     * index
     *
     * @return mixed
     */
    public function index(Request $request): mixed
    {
        return $this->wpUserService->filter($request);
    }
    
    /**
     * store
     *
     * @param  StoreWpUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreWpUserRequest $request): JsonResponse
    {
        $this->authorize('view');

        return  $this->wpUserService->storeWpUser($request->all());
    }
    
    /**
     * affectSitesToUser
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function affectSitesToUser(Request $request): JsonResponse{
        $this->authorize('view');
        
        return  $this->wpUserService->affectSites($request->all());
    }
        
    /**
     * show
     *
     * @param  WpUser $wpUser
     * @return JsonResponse
     */
    public function show(WpUser $wpUser): JsonResponse{
        return $this->wpUserService->getWpUser($wpUser);
    }
   
    /**
     * update
     *
     * @param  UpdateWpUserRequest $request
     * @param  WpUser $wpUser
     * @return JsonResponse
     */
    public function update(UpdateWpUserRequest $request, WpUser $wpUser): JsonResponse
    { 
        $this->authorize('view');

        return  $this->wpUserService->updateWpUser($request->all(), $wpUser, $request->sites);
    }
    
    /**
     * destroy
     *
     * @param  WpUser $wpUser
     * @return JsonResponse
     */
    public function destroy(WpUser $wpUser): JsonResponse
    {
        $this->authorize('view');

        return$this->wpUserService->deleteWpUser($wpUser);
    }    

    /**
     * showDeletedData
     *
     * @param  mixed $request
     * @return void
     */
    public function showDeletedData(Request $request) 
    {
        return $this->wpUserService->showDeletedData($request);
    }
    
    /**
     * restore
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function restore (string $id){
        return $this->wpUserService->restore($id);
    }
    
    /**
     * deleteUserSite
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function deleteUserSite(Request $request): JsonResponse
    {
        if($this->wpUserService->deleteSite($request->user_id, $request->site_id)){
            return response()->json(["message"=>"Site/User successfully detached"]);
        }else{
            return response()->json(["message"=>"User or Site doesn't exist!"], 404);
        }
    }
}
