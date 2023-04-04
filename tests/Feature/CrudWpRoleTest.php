<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CrudWpRoleTest extends TestCase
{
    public function testGetAllWpRoles(): void
    {
        $token= $this->getUserToken();

        $this->withHeader('Authorization', 'Bearer ' . $token)
        ->json('GET', 'api/wp-roles', ['Accept' => 'application/json'])
        ->assertStatus(200);
    }

    public function testStoreWpRole(): void
    {
        $token= $this->getUserToken();

        $role = [
            "name" => fake()->name
        ];

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('POST', 'api/wp-roles', $role, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "name",
                "updated_at",
                "created_at",
                "id",
            ]);
    }

    public function testUpdateWpRole(): void
    {
        $token= $this->getUserToken();

        $role = [
            "name" => fake()->name
        ];

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('PUT', 'api/wp-roles/11', $role, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "name",
                "deleted_at",
                "updated_at",
                "created_at",
            ]);
    }

    public function testDeleteRole(): void
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

    public function testGetWpRole(): void
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