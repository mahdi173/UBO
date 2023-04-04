<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WpRole;
use Tests\TestCase;

class WpRoleTest extends TestCase
{
    public function test_get_all_wpRoles_succefully(): void
    {
        $token= $this->getUserToken();

        $this->withHeader('Authorization', 'Bearer ' . $token)
        ->json('GET', 'api/wp-roles', ['Accept' => 'application/json'])
        ->assertStatus(200);
    }

    public function test_store_wpRole_succefully(): void
    {
        $token= $this->getUserToken();

        $role = WpRole::factory()->make();

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('POST', 'api/wp-roles', $role->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "name",
                "updated_at",
                "created_at",
                "id",
            ]);
    }

    public function test_update_wpRole_succefully(): void
    {
        $token= $this->getUserToken();

        $role = WpRole::factory()->make();

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('PUT', 'api/wp-roles/11', $role->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "name",
                "deleted_at",
                "updated_at",
                "created_at",
            ]);
    }

    public function test_delete_wpRole_succefully(): void
    {        
        $token= $this->getUserToken();

        $id= rand(1,10);
        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('delete', 'api/wp-roles/'.$id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "msg"
            ]);
    }

    public function test_show_wpRole_succefully(): void
    {
        $token= $this->getUserToken();

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('GET', 'api/wp-roles/6', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "name",
                "deleted_at",
                "updated_at",
                "created_at",
            ]);
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