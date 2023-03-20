<?php

namespace App\Services;

use App\Interfaces\WpRoleRepositoryInterface;
use App\Models\WpRole;
use App\Traits\DeleteObjectTrait;
use Illuminate\Http\JsonResponse;

class WpRoleService
{ 
    use DeleteObjectTrait;
    
    /**
     * __construct
     *
     * @param  mixed $userRepository
     * @param  mixed $roleRepository
     * @return void
     */
    public function __construct(private WpRoleRepositoryInterface $wpRoleRepository)
    {
    }

    /**
     * getAllWpRoles
     *
     * @return JsonResponse
     */
    public function getAllWpRoles(): JsonResponse{
        return response()->json($this->wpRoleRepository->getAllWpRoles());
    }
    
    /**
     * storeWpRole
     *
     * @param  string $roleName
     * @return JsonResponse
     */
    public function storeWpRole(string $roleName): JsonResponse 
    {
        $wpRole= $this->wpRoleRepository->createWpRole($roleName);

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
        $wpRole->update($data);
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
        return $this->deleteRecord($wpRole);
    }
}