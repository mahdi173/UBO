<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWpRoleRequest;
use App\Http\Requests\UpdateWpRoleRequest;
use App\Models\WpRole;
use App\Services\WpRoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @return mixed
     */
    public function index(Request $request): mixed
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
        $this->authorize('view');

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
        $this->authorize('view');

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
        $this->authorize('view');

        return $this->wpRoleService->deleteWpRole($wpRole);
    }
    
    /**
     * showDeletedData
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function showDeletedData(Request $request) 
    {
        return $this->wpRoleService->showDeletedData($request);
    }

         /**
     * restore
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function restore (string $id){
        return $this->wpRoleService->restore($id);
    }
}
