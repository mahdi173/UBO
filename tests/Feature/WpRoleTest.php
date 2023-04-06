<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WpRole;
use App\Traits\RequestTrait;
use Tests\TestCase;

class WpRoleTest extends TestCase
{
    use RequestTrait;

    public function test_get_all_wproles_succefully(): void
    {
        $token= $this->getUserToken();

        $this->makeRequest($token, 'GET', 'api/wp-roles', ['Accept' => 'application/json'], 200);
    }

    public function test_store_wprole_succefully(): void
    {
        $token= $this->getUserToken();

        $role = WpRole::factory()->make();

        $structure= [
            "name",
            "updated_at",
            "created_at",
            "id",
        ];

        $param=['Accept' => 'application/json'];

        $this->makeRequest($token, 'POST', 'api/wp-roles', $param, 200, $structure,  $role->toArray());
    }

    public function test_update_wprole_succefully(): void
    {
        $token= $this->getUserToken();

        $role = WpRole::factory()->create();

        $roleUpdate = WpRole::factory()->make();

        $structure= [
            "id",
            "name",
            "deleted_at",
            "updated_at",
            "created_at"
        ];

        $url='api/wp-roles/'.$role->id;

        $param=['Accept' => 'application/json'];

        $this->makeRequest($token, 'PUT', $url, $param, 200, $structure,  $roleUpdate->toArray());
    }

    public function test_delete_wprole_succefully(): void
    {        
        $role = WpRole::factory()->create();

        $token= $this->getUserToken();

        $structure= ["msg"];
        $url='api/wp-roles/'.$role->id;

        $param=['Accept' => 'application/json'];

        $this->makeRequest($token, 'delete', $url, $param, 200, $structure);
    }

    public function test_show_wprole_succefully(): void
    {
        $role = WpRole::factory()->create();

        $token= $this->getUserToken();


        $structure= [
            "id",
            "name",
            "deleted_at",
            "updated_at",
            "created_at",        
        ];

        $url='api/wp-roles/'.$role->id;

        $param=['Accept' => 'application/json'];

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