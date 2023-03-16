<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
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
     * forgotPassword
     *
     * @param  ForgotPasswordRequest $request
     * @return JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {   
       return $this->userService->sendforgotPasswordEmail($request['email']);
    }
    
    /**
     * changePassword
     *
     * @param  string $token
     * @param  ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(string $token, ChangePasswordRequest $request): JsonResponse
    {
        return $this->userService->changeUserPassword($token, $request["password"]);
    }
}
