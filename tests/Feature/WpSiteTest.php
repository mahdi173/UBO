<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WpSite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WpSiteTest extends TestCase
{
    public function test_get_all_wpSites_succefully(): void
    {
        $token= $this->getUserToken();

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('GET', 'api/wp-sites', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function test_store_wpSite_succefully(): void
    {
        $token= $this->getUserToken();

        $data = [
            "name" => fake()->name,
            "domain" => fake()->name,
            "pole_id" => 1,
            "type_id" => 1
        ];

       $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('POST', 'api/wp-sites', $data, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "name",
                "domain",
                "created_at",
                "updated_at",
                "id",
                "pole",
                "type"
            ]);
    }

    public function test_update_wpSite_succefully(): void
    {
        $token= $this->getUserToken();

        $data = [
            "name" => fake()->name,
        ];

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('PUT', 'api/wp-sites/4', $data, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "name",
                "domain",
                "deleted_at",
                "created_at",
                "updated_at",
                "pole",
                "type"
            ]);
    }

    public function test_delete_wpSite_succefully(): void
    {
        $token= $this->getUserToken();

        $id= rand(1,10);
        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('delete', 'api/wp-sites/'.$id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "msg"
            ]);
    }

    public function test_show_wpSite_succefully(): void
    {
        $token= $this->getUserToken();

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('GET', 'api/wp-sites/4', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "name",
                "domain",
                "deleted_at",
                "created_at",
                "updated_at",
                "pole",
                "type",
                "users"=> []
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
