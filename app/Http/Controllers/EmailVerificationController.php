<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
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
     * verify
     *
     * @param  mixed $userId
     * @return void
     */
    public function verify($userId) 
    {
        if($this->userService->verifyEmail($userId)){
            return redirect()->to('/');
        }
    }
        
    /**
     * resend
     *
     * @return void
     */
    public function resend() 
    {
       return $this->userService->resendEmail();
    }
    
}
