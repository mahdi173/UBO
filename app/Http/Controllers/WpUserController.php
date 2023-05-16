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

        return  $this->wpUserService->updateWpUser($request->all(), $wpUser);
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
}
