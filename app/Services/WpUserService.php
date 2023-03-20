<?php

namespace App\Services;

use App\Interfaces\WpUserRepositoryInterface;
use App\Models\WpUser;
use App\Traits\DeleteObjectTrait;
use Illuminate\Http\JsonResponse;

class WpUserService
{ 
    use DeleteObjectTrait;
    
      
    /**
     * __construct
     *
     * @param  WpUserRepositoryInterface $wpUserRepository
     * @return void
     */
    public function __construct(private WpUserRepositoryInterface $wpUserRepository)
    {
    }

    /**
     * getAllWpUsers
     *
     * @return JsonResponse
     */
    public function getAllWpUsers(): JsonResponse
    {
        $data= $this->wpUserRepository->getAllWpUsers();

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
        $userData= [
            'userName' => $data['userName'],
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ];
      
        $wpUser = $this->wpUserRepository->createWpUser($userData);

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
        $wpUser->update($data);
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
        return $this->deleteRecord($wpUser);
    }
}