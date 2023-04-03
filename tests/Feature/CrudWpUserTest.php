<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CrudWpUserTest extends TestCase
{
    public function testGetAllWpUsers(): void
    {
        $this->json('GET', 'api/wp-users', ['Accept' => 'application/json'])
        ->assertStatus(200);
    }

    public function testStoreWpUser(): void
    {
        $data = [
            "userName" => fake()->name,
            "firstName" => "John",
            "lastName" => "Doe",
            "email" => fake()->safeEmail()
        ];

        $this->json('POST', 'api/wp-users', $data, ['Accept' => 'application/json'])
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
        $data = [
            "lastName" => "update",
            "email" => fake()->safeEmail()
        ];

        $this->json('PUT', 'api/wp-users/18', $data, ['Accept' => 'application/json'])
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
        $id= rand(1,10);
        $this->json('delete', 'api/wp-users/'.$id, ['Accept' => 'application/json'])
        ->assertStatus(200)
        ->assertJsonStructure([
            "msg"
        ]);
    }

    public function testGetWpUser(): void
    {
        $this->json('GET', 'api/wp-users/4', ['Accept' => 'application/json'])
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
}
