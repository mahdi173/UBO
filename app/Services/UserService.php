<?php

namespace App\Services;

use stdClass;
use Carbon\Carbon;
use App\Models\User;
use App\Jobs\SendMailJob;
use App\Mail\SendMailreset;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;

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
     * @param  array $data
     * @return JsonResponse
     */
    public function storeUser(array $data): JsonResponse
    {
        $user = $this->userRepository->create($data);
        $email= $user->email;
        $user_token= $user->createToken('password-token', ['activate-account']);

        $mail= new SendMailreset($user_token->accessToken->token, $email, "resetpassword");
        SendMailJob::dispatch($mail);
        
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
     * @return mixed
     */
    public function filter(Request $request): mixed
    {           
        $response= new stdClass();
        $filter= User::filter($request->input('filters'),$request->input('sort'))
        ->where('id', '!=', Auth::id());
        if (!$request->paginate) {
            $response->data = $filter->get();
        } else {
            $response = $filter->paginate($request->paginate);
        }
        return $response;
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
    
    /**
     * verifyUserToken
     *
     * @param  string $token
     * @return User
     */
    public function verifyUserToken(string $token): User
    {
        $user_token = PersonalAccessToken::where('token', $token)->first();

        $user= User::findOrFail($user_token->toArray()["tokenable_id"]);   

        if($user->email_verified_at){
            abort(419, 'Token expired');
        }
        
        return $user;
    }
    
    /**
     * createUserPassword
     *
     * @param  array $data
     * @return JsonResponse
     */
    public function createUserPassword(array $data): JsonResponse
    {
        $user= $this->verifyUserToken($data["token"]);

        $this->userRepository->update($user, ["password"=>bcrypt( $data["password"]),
                                                "email_verified_at"=> Carbon::now()
                                            ]
                                    );
        
        return response()->json(['message' => 'Password updated Successfully']);
    }
    
    /**
     * sendResetPasswordEmail
     *
     * @param  string $email
     * @return JsonResponse
     */
    public function sendResetPasswordEmail(string $email): JsonResponse{
        $user= $this->userRepository->getUserByEmail($email);

        $user_token= $user->createToken('reset-password-token', ['reset-password'], now()->addMinutes(10));

        $mail= new SendMailreset($user_token->accessToken->token, $email, "forgotpassword");
        SendMailJob::dispatch($mail);
                
        return response()->json(['message' => 'Email sent successfully']);
    }
    
    /**
     * resetUserPassword
     *
     * @param  array $data
     * @return JsonResponse
     */
    public function resetUserPassword(array $data): JsonResponse{
        $user= $this->verifyUserToken($data["token"]);

        $this->userRepository->update($user, ["password"=>bcrypt( $data["password"])]);
        
        return response()->json(['message' => 'Password updated Successfully']);
    }
     
        /**
     * showDeletedData
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function showDeletedData(Request $request): mixed{
        $response= new stdClass();

        $deletedUsers=User::onlyTrashed()->filter(

            $request->input('filters'),
            $request->input('sort')
            );
           if(!$request->paginate){
            $response->data= $deletedUsers->get();

           }else{
            $response= $deletedUsers->paginate($request->paginate);
           }

           return $response;
    }
    
      /**
     * restore
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function restore (string $id): JsonResponse{
        
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return response()->json([
            'message' => 'User restored successfully',
            'data' => $user
        ]);
} 
}