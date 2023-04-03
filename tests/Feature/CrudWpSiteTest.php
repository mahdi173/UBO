<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CrudWpSiteTest extends TestCase
{
    public function testGetAllWpSites(): void
    {
        $this->json('GET', 'api/wp-sites', ['Accept' => 'application/json'])
        ->assertStatus(200);
    }

    public function testStoreWpSite(): void
    {
        $data = [
            "name" => fake()->name,
            "domain" => fake()->name,
            "pole_id" => 1,
            "type_id" => 1
        ];

        $this->json('POST', 'api/wp-sites', $data, ['Accept' => 'application/json'])
        ->assertStatus(200)
        ->assertJsonStructure([
            "name",
            "domain",
            "pole_id",
            "type_id",
            "created_at",
            "updated_at",
            "id"
        ]);
    }

    public function testUpdateWpSite(): void
    {
        $data = [
            "name" => fake()->name,
        ];

        $this->json('PUT', 'api/wp-sites/4', $data, ['Accept' => 'application/json'])
        ->assertStatus(200)
        ->assertJsonStructure([
            "id",
            "name",
            "domain",
            "deleted_at",
            "created_at",
            "updated_at",
            "pole_id",
            "type_id",
        ]);
    }

    public function testDeleteWpSite(): void
    {
        $id= rand(1,10);
        $this->json('delete', 'api/wp-sites/'.$id, ['Accept' => 'application/json'])
        ->assertStatus(200)
        ->assertJsonStructure([
            "msg"
        ]);
    }

    public function testGetWpSite(): void
    {
        $this->json('GET', 'api/wp-sites/4', ['Accept' => 'application/json'])
        ->assertStatus(200)
        ->assertJsonStructure([
            "id",
            "name",
            "domain",
            "deleted_at",
            "created_at",
            "updated_at",
            "pole_id",
            "type_id",
        ]);
    }
}
