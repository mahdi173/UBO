<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CrudWpRoleTest extends TestCase
{
    public function testGetAllWpRoles(): void
    {
        $this->json('GET', 'api/wp-roles', ['Accept' => 'application/json'])
        ->assertStatus(200);
    }

    public function testStoreWpRole(): void
    {
        $data = [
            "name" => fake()->name
        ];

        $this->json('POST', 'api/wp-roles', $data, ['Accept' => 'application/json'])
        ->assertStatus(200)
        ->assertJsonStructure([
            "name",
            "updated_at",
            "created_at",
            "id"
        ]);
    }

    public function testUpdateWpRole(): void
    {
        $data = [
            "name" => fake()->name
        ];

        $this->json('PUT', 'api/wp-roles/11', $data, ['Accept' => 'application/json'])
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
        $id= rand(1,10);
        $this->json('delete', 'api/wp-roles/'.$id, ['Accept' => 'application/json'])
        ->assertStatus(200)
        ->assertJsonStructure([
            "msg"
        ]);
    }

    public function testGetWpRole(): void
    {
        $this->json('GET', 'api/wp-roles/6', ['Accept' => 'application/json'])
        ->assertStatus(200)
        ->assertJsonStructure([
            "id",
            "name",
            "deleted_at",
            "updated_at",
            "created_at",
        ]);
    }
}
