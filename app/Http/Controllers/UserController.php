<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * __construct
     *
     * @param  UserService $userService
     * @return void
     */
    public function __construct(private UserService  $userService)
    {
    }

    /**
     * index
     *
     * @return mixed
     */
    public function index(Request $request): mixed
    {
        return $this->userService->filter($request);
    }
    
     /**
     * store
     *
     * @param  RegisterRequest $request
     * @return JsonResponse
     */
    public function store(RegisterRequest $request): JsonResponse
    {
        $this->authorize('create',  User::class);
  
        return  $this->userService->storeUser($request->all());
    }

    /**
     * update
     *
     * @param  UpdateUserRequest $request
     * @param  User $user
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    { 
        $this->authorize('update',  User::class);

        return  $this->userService->updateUser( $user, $request->all());
    }

    /**
     * show
     *
     * @param  User $User
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse{
        return $this->userService->getUser($user);
    }
   
    /**
     * destroy
     *
     * @param  User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete',  User::class);

        return$this->userService->deleteUser($user);
    }
}
