<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWpRoleRequest;
use App\Http\Requests\UpdateWpRoleRequest;
use App\Models\WpRole;
use App\Services\WpRoleService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class WpRoleController extends Controller
{
     /**
     * __construct
     *
     * @param  WpRoleService $wpRoleService
     * @return void
     */
    public function __construct(private WpRoleService  $wpRoleService)
    {
    }
    
    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
      return $this->wpRoleService->filter($request);
    }
    
    /**
     * store
     *
     * @param  StoreWpRoleRequest $request
     * @return JsonResponse
     */
    public function store(StoreWpRoleRequest $request): JsonResponse
    {
        if ($request->user()->cannot('createWpRole', WpRole::class)) {
            abort(403);
        }
        return $this->wpRoleService->storeWpRole($request->all());
    }
    
    /**
     * show
     *
     * @param  WpRole $wpRole
     * @return JsonResponse
     */
    public function show(WpRole $wpRole): JsonResponse{
        return response()->json($wpRole);
    }
   
    /**
     * update
     *
     * @param  UpdateWpRoleRequest $request
     * @param  WpRole $wpRole
     * @return JsonResponse
     */
    public function update(UpdateWpRoleRequest $request, WpRole $wpRole): JsonResponse
    {
        if ($request->user()->cannot('updateWpRole', WpRole::class)) {
            abort(403);
        }
        return $this->wpRoleService->updateWpRole($request->all(), $wpRole);
    }
        
    /**
     * destroy
     *
     * @param  WpRole $wpRole
     * @return JsonResponse
     */
    public function destroy(WpRole $wpRole): JsonResponse
    {
        if(Auth::user()->cannot('delete', WpRole::class)){
            abort(403); 
        }
        return $this->wpRoleService->deleteWpRole($wpRole);
    }
}
