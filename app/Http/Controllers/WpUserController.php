<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\StoreWpUserRequest;
use App\Http\Requests\UpdateWpUserRequest;
use App\Models\WpUser;
use App\Services\WpUserService;
use Illuminate\Auth\Access\AuthorizationException;
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
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
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
        if ($request->user()->cannot('createWpUser', WpUser::class)) {
            abort(403);
        }
        return  $this->wpUserService->storeWpUser($request->all());
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
        if ($request->user()->cannot('updateWpUser', WpUser::class)) {
            abort(403);
        }
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
        try {
            $this->authorize('deleteWpUser', WpUser::class);
        }catch (AuthorizationException){
            abort(403);
        }
        return$this->wpUserService->deleteWpUser($wpUser);
    }
}
