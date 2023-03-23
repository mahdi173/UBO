<?php

namespace App\Services;

use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserService
{        
    /**
     * __construct
     *
     * @param  UserRepositoryInterface $userRepositoryInterface
     * @param  RoleRepositoryInterface $roleRepository
     * @param  UserRepository $userRepository
     * @return void
     */
    public function __construct(private UserRepositoryInterface  $userRepositoryInterface, private RoleRepositoryInterface $roleRepository, private UserRepository $userRepository)
    {
    }

    /**
     * storeUser
     *
     * @param  mixed $data
     * @return JsonResponse
     */
    public function storeUser($data): JsonResponse
    {
        $role= $this->roleRepository->getRoleByName("user");

        $user = $this->userRepository->create($data, $role->id);

        return response()->json([
            'message' => 'User Created Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }
    
    /**
     * createUserToken
     *
     * @param  mixed $email
     * @param  mixed $password
     * @return JsonResponse|array
     */
    public function createUserToken(string $email, string $password): JsonResponse|array
    {
        $user = $this->userRepositoryInterface->getUserByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'msg' => 'Incorrect email or password'
            ], 400);
        }

        $token = $user->createToken('apiToken')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }
}