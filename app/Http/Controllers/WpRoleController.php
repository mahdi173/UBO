<?php

namespace App\Http\Controllers;

use App\Filters\WpRoleFilters;
use App\Http\Requests\StoreWpRoleRequest;
use App\Models\WpRole;
use App\Services\WpRoleService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

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
    public function index(WpRoleFilters $filters): JsonResponse
    {
      return $this->wpRoleService->filter($filters);
    }
    
    /**
     * store
     *
     * @param  StoreWpRoleRequest $request
     * @return JsonResponse
     */
    public function store(StoreWpRoleRequest $request): JsonResponse
    {
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
     * @param  StoreWpRoleRequest $request
     * @param  WpRole $wpRole
     * @return JsonResponse
     */
    public function update(StoreWpRoleRequest $request, WpRole $wpRole): JsonResponse
    {
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
        return $this->wpRoleService->deleteWpRole($wpRole);
    }
}
