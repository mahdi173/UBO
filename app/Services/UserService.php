<?php

namespace App\Services;

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
     * storeUser
     *
     * @param  mixed $data
     * @return JsonResponse
     */
    public function storeUser($data): JsonResponse
    {
        $userRoleId= Role::where('name', '=', "user")->first()->id;
        $user = User::create([
            'userName' => $data['userName'],
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id'=> $userRoleId
        ]);

        $user->sendEmailVerificationNotification();

        return response()->json([
            'status' => true,
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
        $user = User::where('email', $email)->first();

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
        $user = User::findOrFail($userId);
    
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

    public function sendforgotPasswordEmail($email): JsonResponse
    {
        $user= User::where("email","=",$email)->first();

        if($user){
            $token = $this->createResetPasswordToken($email);
            Mail::to($email)->send(new SendMailreset($token, $email));

            return response()->json([
                'data' => "Reset email link sent successfully, please check your inbox",
                'token'=>$token
            ], 200);
        }

        return response()->json([
            'error' => "Email was not found in the Database"
        ], 404);
    }

    public function createResetPasswordToken($email)
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

    public function changeUserPassword(string $token, string $password): JsonResponse
    {
        $query = DB::table('password_reset_tokens')->where('token', $token);
        $passwordToken= $query->first();

        if($passwordToken)
        {
            $user= User::where('email', $passwordToken->email)->first();

            $user->update(['password' => Hash::make($password)]);
            
            $query->delete();
            
            return response()->json(["message" => "Password updated successfully."], 200);
        }

        return response()->json(["message" => "Token doesn't exist."], 400);
    }

}