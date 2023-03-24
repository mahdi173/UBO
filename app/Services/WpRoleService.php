<?php

namespace App\Services;

use App\Models\WpRole;
use App\Repositories\WpRoleRepository;
use Illuminate\Http\JsonResponse;

class WpRoleService
{     
    /**
     * __construct
     *
     * @param  WpRoleRepository $roleRepository
     * @return void
     */
    public function __construct(private WpRoleRepository $roleRepository)
    {
    }

    /**
     * getAllWpRoles
     *
     * @return JsonResponse
     */
    public function getAllWpRoles(): JsonResponse{
        return response()->json($this->roleRepository->getAll());
    }
    
    /**
     * storeWpRole
     *
     * @param  array $data
     * @return JsonResponse
     */
    public function storeWpRole(array $data): JsonResponse 
    {
        $wpRole= $this->roleRepository->create($data);
        return response()->json($wpRole);
    }
    
    /**
     * updateWpRole
     *
     * @param  array $data
     * @param  WpRole $wpRole
     * @return JsonResponse
     */
    public function updateWpRole(array $data, WpRole $wpRole): JsonResponse
    {
        $this->roleRepository->update($wpRole, $data);
        return response()->json($wpRole, 200);
    }
    
    /**
     * deleteWpRole
     *
     * @param  WpRole $wpRole
     * @return JsonResponse
     */
    public function deleteWpRole( WpRole $wpRole): JsonResponse
    {
        $this->roleRepository->delete($wpRole);
        return response()->json(["msg"=>"Item successfully deleted!"], 200);
    }
}