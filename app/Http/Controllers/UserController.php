<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
        if ($request->user()->cannot('create', User::class)) {
            abort(403);
        }
  
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
        if ($request->user()->cannot('update', User::class)) {
            abort(403);
        }

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
        if (Gate::denies('delete', $user)) {
            abort(403);
        } 
        return$this->userService->deleteUser($user);
    }
}
