<?php

namespace App\Services;

use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Jobs\SendMailJob;
use App\Mail\SendMailreset;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use stdClass;

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

        $mail= new SendMailreset($user_token->accessToken->token, $email);
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
        $filter= User::filter($request->input('filters'),$request->input('sort'));

        if(!$request->paginate){
            $response->data= $filter->get();
        }else{
            $response= $filter->paginate($request->paginate);
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
     * @return JsonResponse|string
     */
    public function verifyUserToken(string $token): JsonResponse|string
    {
        $user_token = PersonalAccessToken::where('token', $token)->first();

        $user= User::where("id", $user_token->toArray()["tokenable_id"])->first();   

        if($user->email_verified_at){
            return response()->json(['error' => 'Token expired'], 419);
        }
        
        return $user->email;
    }
    
    /**
     * createUserPassword
     *
     * @param  array $data
     * @return JsonResponse
     */
    public function createUserPassword(array $data): JsonResponse
    {
        $response= $this->verifyUserToken($data["token"]);

        if(gettype($response)=="string"){
            $user= User::where("email", $response)->first();   

            $this->userRepository->update($user, ["password"=>bcrypt( $data["password"]),
                                                    "email_verified_at"=> Carbon::now()
                                                ]
                                        );
            
            return response()->json(['message' => 'Password updated Successfully']);
        }

        return $response;
    }
}