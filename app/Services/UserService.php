<?php

namespace App\Services;

use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        $user = $this->userRepository->create($data);

        //$user->createToken("API TOKEN")->plainTextToken
        return response()->json([
            'message' => 'User Created Successfully',
            'user' => $user
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
            ], 422);
        }

        $token = $user->createToken('apiToken')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

     /**
     * filter
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function filter(Request $request): JsonResponse
    {           
        $results= User::filter($request->input('filters'),$request->input('sort') ,$request->paginate);

        if(!$request->paginate){
            return  response()->json(["data"=> $results->get()]);
        }else{
            return response()->json($results);
        }
    }

    public function UpdateUser(User $user, array $data): JsonResponse
    {
        $this->userRepository->update($user, $data);
        return response()->json($user->load('role'), 200);
    }

    public function getUser(User $user): JsonResponse
    {
        return response()->json($user->load('role'), 200);
    }
    
    public function deleteUser( User $user): JsonResponse
    {
        $this->userRepository->delete($user);
        return response()->json(["msg"=>"Item successfully deleted!"], 200);
    }
}