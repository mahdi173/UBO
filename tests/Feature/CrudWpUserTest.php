<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CrudWpUserTest extends TestCase
{
    public function testGetAllWpUsers(): void
    {
        $token= $this->getUserToken();

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('GET', 'api/wp-users', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function testStoreWpUser(): void
    {
        $token= $this->getUserToken();

        $data = [
            "userName" => fake()->name,
            "firstName" => "John",
            "lastName" => "Doe",
            "email" => fake()->safeEmail()
        ];

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('POST', 'api/wp-users', $data, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "userName",
                "firstName",
                "lastName",
                "email",
                "created_at",
                "updated_at",
                "id"
            ]);
    }

    public function testUpdateWpUser(): void
    {
        $token= $this->getUserToken();

        $data = [
            "lastName" => "update",
            "email" => fake()->safeEmail()
        ];

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('PUT', 'api/wp-users/18', $data, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "userName",
                "firstName",
                "lastName",
                "email",
                "email_verified_at",
                "deleted_at",
                "created_at",
                "updated_at",
            ]);
    }

    public function testDeleteWpUser(): void
    {
        $token= $this->getUserToken();

        $id= rand(1,10);
        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('delete', 'api/wp-users/'.$id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "msg"
            ]);
    }

    public function testGetWpUser(): void
    {
        $token= $this->getUserToken();

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('GET', 'api/wp-users/4', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
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
