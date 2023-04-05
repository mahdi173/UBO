<?php

namespace Tests\Feature;

use App\Models\User;
use App\Traits\RequestTrait;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RequestTrait;

    public function test_register_user_succefully()
    {
        $user= User::factory()->make();
        $userData= $user->toArray();
        $userData["password"] = "secret123455";
        $userData["password_confirmation"] = "secret123455";

        $structure= [
            "message",
            "token"
        ];

        $param=['Accept' => 'application/json'];

        $this->makeRequest(null, 'POST', 'api/register', $param, 200, $structure,  $userData);
    }

    public function test_login_user_succefully()
    {
        $user=  User::factory()->create();

        $loginData = [
            "email" => $user->email,
            "password" => "secret",
        ];

        $structure= [
            "user"=>[
                "id",
                "userName",
                "firstName",
                "lastName",
                "email",
                "email_verified_at",
                "deleted_at",
                "created_at",
                "updated_at",
                "role_id"
            ],
            "token"
        ];

        $param=['Accept' => 'application/json'];

        $this->makeRequest(null, 'POST', 'api/login', $param, 200, $structure,  $loginData);
    }
}
