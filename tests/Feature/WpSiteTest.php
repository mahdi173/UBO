<?php

namespace Tests\Feature;

use App\Models\Pole;
use App\Models\Type;
use App\Models\User;
use App\Models\WpSite;
use App\Models\WpUser;
use App\Traits\RequestTrait;
use Tests\TestCase;

class WpSiteTest extends TestCase
{
    use RequestTrait;

    public function test_get_all_wpsites_succefully(): void
    {
        $token= $this->getUserToken();

        $this->makeRequest($token, 'GET', 'api/wp-sites', ['Accept' => 'application/json'], 200);
    }

    public function test_store_wpsite_succefully(): void
    {
        $token= $this->getUserToken();

        $site= WpSite::factory()->make();
        $pole= Pole::factory()->create();
        $type= Type::factory()->create();

        $siteData = $site->toArray();
        $siteData ["type_id"]= $type->id;
        $siteData["pole_id"]= $pole->id;

        $structure= [
            "name",
            "domain",
            "created_at",
            "updated_at",
            "id"
        ];

        $param=['Accept' => 'application/json'];

        $this->makeRequest($token, 'POST', 'api/wp-sites', $param, 200, $structure, $siteData);
    }

    public function test_affect_users_to_wpsite_succefully(): void
    {
        $site= WpSite::factory()->create();

        $user1= WpUser::inRandomOrder()->first();
        $user2= WpUser::inRandomOrder()->first();

        $token= $this->getUserToken();

        $data = [
            "id" => $site->id,
            "users" => [
                [
                    "id"=> $user1->id,
			        "roles"=> ["Editor", "Author"],
                    "username"=> $user1->userName
                ],
                [
                    "id"=> $user2->id,
			        "roles"=> ["Editor", "Contributor"],
                    "username"=> $user1->userName
                ]
            ]
        ];

        $structure= ["msg"];
        $param= ['Accept' => 'application/json'];
        $url= 'api/wp-sites-users';

        $this->makeRequest($token, 'POST', $url, $param, 200, $structure, $data);
    }

    public function test_update_wpsite_succefully(): void
    {
        $site= WpSite::factory()->create();

        $token= $this->getUserToken();

        $data = [
            "name" => fake()->name,
        ];

        $structure=[
            "id",
            "name",
            "domain",
            "deleted_at",
            "created_at",
            "updated_at"
        ];

        $param=['Accept' => 'application/json'];
        $url= 'api/wp-sites/'.$site->id;

        $this->makeRequest($token, 'PUT', $url, $param, 200, $structure, $data);
    }

    public function test_delete_wpsite_succefully(): void
    {
        $site= WpSite::factory()->create();

        $token= $this->getUserToken();

        $structure=["msg"];

        $param=['Accept' => 'application/json'];
        $url= 'api/wp-sites/'.$site->id;

        $this->makeRequest($token, 'delete', $url, $param, 200, $structure);
    }

    public function test_show_wpsite_succefully(): void
    {
        $site= WpSite::factory()->create();

        $token= $this->getUserToken();

        $structure= [
            "id",
            "name",
            "domain",
            "deleted_at",
            "created_at",
            "updated_at",
            "users"=> []
        ];
        
        $param= ['Accept' => 'application/json'];
        $url= 'api/wp-sites/'.$site->id;

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
}
