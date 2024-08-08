<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Traits\RequestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RequestTrait;

    public function test_get_all_user_succefully(): void
    {
        $token= $this->getUserToken();

        $this->makeRequest($token, 'GET', 'api/wp-sites', ['Accept' => 'application/json'], 200);
    }

    public function test_store_user_succefully(): void
    {
        $token= $this->getUserToken();

        $user= User::factory()->make();
        $role= Role::inRandomOrder()->first();
        $data = [
            "userName" => $user->userName,
            "firstName" => $user->firstName,
            "lastName" => $user->lastName,
            "email" => $user->email,
            "role_id" => $role->id
        ];

        $structure= [
            "message",
            "user" => []
        ];

        $param=['Accept' => 'application/json'];

        $this->makeRequest($token, 'POST', 'api/users', $param, 200, $structure, $data);
    }

    public function test_update_user_succefully(): void
    {
        $user= User::factory()->make();

        $token= $this->getUserToken();

        $data = [
            "firstName" => fake()->name,
        ];

        $structure=[
            "id",
            "userName",
            "firstName",
            "lastName",
            "email",
            "email_verified_at",
            "deleted_at",
            "created_at",
            "updated_at",
            "role_id",
            "role"
        ];

        $param=['Accept' => 'application/json'];
        $url= 'api/users/'.$user->id;

        $this->makeRequest($token, 'put', $url, $param, 200, $structure, $data);
    }

    public function test_delete_user_succefully(): void
    {
        $user= User::factory()->create();

        $token= $this->getUserToken();

        $structure=["msg"];

        $param=['Accept' => 'application/json'];
        $url= 'api/users/'.$user->id;

        $this->makeRequest($token, 'delete', $url, $param, 200, $structure);
    }

    public function test_show_user_succefully(): void
    {
        $user= User::factory()->create();

        $token= $this->getUserToken();

        $structure=[
            "id",
            "userName",
            "firstName",
            "lastName",
            "email",
            "email_verified_at",
            "deleted_at",
            "created_at",
            "updated_at",
            "role_id",
            "role"=>[]
        ];
        
        $param= ['Accept' => 'application/json'];
        $url= 'api/users/'.$user->id;

        $this->makeRequest($token, 'GET', $url, $param, 200, $structure);
    }

    
    public function getUserToken()
    {
        $loginData = [
            "email" => "admin@email.com",
            "password" => "admin",
        ];

        $response= $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json']);
        $data=json_decode($response->getContent());
        return $data->token;
    }

    public function test_verify_token_succefully(): void
    {
        $token= $this->getUserToken();

        $user= User::factory()->create();
        $user_token= $user->createToken('password-token', ['activate-account']);
        $token= $user_token->accessToken->token;

        $data = [
            "token" => $token
        ];

        $structure= [
            "message"
        ];

        $param=['Accept' => 'application/json'];

      
       $this->makeRequest($token, 'POST', 'api/users/verify-token', $param, 200, $structure, $data);
    }

    public function test_reset_password_succefully(): void
    {
        $token= $this->getUserToken();

        $user= User::factory()->create();
        $user_token= $user->createToken('password-token', ['activate-account']);
        $token= $user_token->accessToken->token;

        $data = [
            "token" => $token,
            "password"=> "secret"
        ];

        $structure= [
            "message"
        ];

        $param=['Accept' => 'application/json'];

        $this->makeRequest($token, 'POST', 'api/users/create-password', $param, 200, $structure, $data);
    }
}
