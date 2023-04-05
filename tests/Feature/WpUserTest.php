<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WpUser;
use App\Traits\RequestTrait;
use Tests\TestCase;

class WpUserTest extends TestCase
{
    use RequestTrait;

    public function test_get_all_wpusers_succefully(): void
    {
        $token= $this->getUserToken();

        $this->makeRequest($token, 'GET', 'api/wp-users', ['Accept' => 'application/json'], 200);
    }

    public function test_store_wpuser_succefully(): void
    {
        $token= $this->getUserToken();

        $data = WpUser::factory()->make();

        $structure= [
            "userName",
            "firstName",
            "lastName",
            "email",
            "created_at",
            "updated_at",
            "id"
        ];

        $param= ['Accept' => 'application/json'];
        $url= 'api/wp-users';

        $this->makeRequest($token, 'POST', $url, $param, 200, $structure,  $data->toArray());
    }

    public function test_update_wpuser_succefully(): void
    {
        $user= WpUser::factory()->create();

        $token= $this->getUserToken();

        $data = [
            "lastName" => "update",
            "email" => fake()->safeEmail()
        ];

        $structure= [
            "id",
            "userName",
            "firstName",
            "lastName",
            "email",
            "email_verified_at",
            "deleted_at",
            "created_at",
            "updated_at"
        ];

        $param= ['Accept' => 'application/json'];
        $url= 'api/wp-users/'.$user->id;

        $this->makeRequest($token, 'PUT', $url, $param, 200, $structure,  $data);
    }

    public function test_delete_wpuser_succefully(): void
    {
        $user= WpUser::factory()->create();

        $token= $this->getUserToken();

        $structure= ["msg"];

        $param= ['Accept' => 'application/json'];
        $url= 'api/wp-users/'.$user->id;

        $this->makeRequest($token, 'delete', $url, $param, 200, $structure);
    }

    public function test_show_wpuser_succefully(): void
    {
        $user= WpUser::factory()->create();

        $token= $this->getUserToken();

        $structure= [
            "id",
            "userName",
            "firstName",
            "lastName",
            "email",
            "email_verified_at",
            "deleted_at",
            "created_at",
            "updated_at",
            "sites"=> []
        ];

        $param= ['Accept' => 'application/json'];
        $url= 'api/wp-users/'.$user->id;

        $this->makeRequest($token, 'GET', $url, $param, 200, $structure);
    }
    
    public function getUserToken(){
        $user=  User::factory()->create();
        $loginData = [
            "email" => $user->email,
            "password" => "secret",
        ];

        $response= $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json']);
        $data=json_decode($response->getContent());
        return $data->token;
    }
}
