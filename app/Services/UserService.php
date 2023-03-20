<?php

namespace App\Services;

use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Mail\SendMailreset;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserService
{        
    /**
     * __construct
     *
     * @param  mixed $userRepository
     * @param  mixed $roleRepository
     * @return void
     */
    public function __construct(private UserRepositoryInterface  $userRepository, private RoleRepositoryInterface $roleRepository)
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
        $userData= [
            'userName' => $data['userName'],
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id'=> $role->id
        ];

        $user = $this->userRepository->createUser($userData);

        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'User Created Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }
    
    /**
     * checkCredentials
     *
     * @param  mixed $email
     * @param  mixed $password
     * @return JsonResponse|array
     */
    public function checkCredentials(string $email, string $password): JsonResponse|array
    {
        $user = $this->userRepository->getUserByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'msg' => 'Incorrect email or password'
            ], 401);
        }

        $token = $user->createToken('apiToken')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }
    
    /**
     * verifyEmail
     *
     * @param  int $userId
     * @return bool
     */
    public function verifyEmail(int $userId): bool
    {
        $user = $this->userRepository->getUserById($userId);
    
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return true;
        }

        return false;
    }
    
    /**
     * resendEmail
     *
     * @return JsonResponse
     */
    public function resendEmail(): JsonResponse{
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json(["msg" => "Email already verified."], 400);
        }
    
        auth()->user()->sendEmailVerificationNotification();
    
        return response()->json(["msg" => "Email verification link sent to your email"]);
    }
    
    /**
     * sendforgotPasswordEmail
     *
     * @param  string $email
     * @return JsonResponse
     */
    public function sendforgotPasswordEmail(string $email): JsonResponse
    {
        $user= $this->userRepository->getUserByEmail($email);

        if($user){
            $token = $this->createResetPasswordToken($email);
            Mail::to($email)->send(new SendMailreset($token, $email));

            return response()->json([
                'msg' => "Reset email link sent successfully, please check your inbox",
                'token'=>$token
            ], 200);
        }

        return response()->json([
            'error' => "Email was not found in the Database"
        ], 404);
    }
    
    /**
     * createResetPasswordToken
     *
     * @param  string $email
     * @return string
     */
    public function createResetPasswordToken(string $email): string
    {

        $oldToken = DB::table('password_reset_tokens')->where('email', $email)->first();

        if ($oldToken) {
            return $oldToken->token;
        }

        $token = Str::random(40);

        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        return $token;
    }
    
    /**
     * changeUserPassword
     *
     * @param  string $token
     * @param  string $password
     * @return JsonResponse
     */
    public function changeUserPassword(string $token, string $password): JsonResponse
    {
        $query = DB::table('password_reset_tokens')->where('token', $token);
        $passwordToken= $query->first();

        if($passwordToken)
        {
            $user= $this->userRepository->getUserByEmail($passwordToken->email);

            $user->update(['password' => Hash::make($password)]);
            
            $query->delete();
            
            return response()->json(["message" => "Password updated successfully."], 200);
        }

        return response()->json(["message" => "Token doesn't exist."], 400);
    }

}