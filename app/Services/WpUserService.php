<?php

namespace App\Services;

use App\Interfaces\CrudInterface;
use App\Models\WpUser;
use App\Repositories\WpUserRepository;
use Illuminate\Http\JsonResponse;

class WpUserService
{         
    /**
     * __construct
     *
     * @param  WpUserRepository $wpUserRepository
     * @return void
     */
    public function __construct(private WpUserRepository $wpUserRepository)
    {
    }

    /**
     * getAllWpUsers
     *
     * @return JsonResponse
     */
    public function getAllWpUsers(): JsonResponse
    {
        $data= $this->wpUserRepository->getAll();
        return response()->json($data);
    }
    
    /**
     * storeWpUser
     *
     * @param  array $data
     * @return JsonResponse
     */
    public function storeWpUser(array $data): JsonResponse 
    { 
        $wpUser = $this->wpUserRepository->create($data);
        return response()->json($wpUser, 200);
    }
    
    /**
     * updateWpUser
     *
     * @param  array $data
     * @param  WpUser $wpUser
     * @return JsonResponse
     */
    public function updateWpUser(array $data, WpUser $wpUser): JsonResponse
    {
        $this->wpUserRepository->update($wpUser, $data);
        return response()->json($wpUser, 200);
    }
    
    /**
     * deleteWpUser
     *
     * @param  WpUser $wpUser
     * @return JsonResponse
     */
    public function deleteWpUser( WpUser $wpUser): JsonResponse
    {
        $this->wpUserRepository->delete($wpUser);
        return response()->json(["msg"=>"Item successfully deleted!"], 200);
    }
}