<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
   
    public function testRegistration()
    {
        $userData = [
            "userName" => fake()->name,
            "firstName" => "John",
            "lastName" => "Doe",
            "email" => fake()->safeEmail(),
            "password" => "demo12345",
            "password_confirmation" => "demo12345"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "message",
                "token"
            ]);
    }

    public function testLogin()
    {
        $loginData = [
            "email" => "testnewubo@email.com",
            "password" => "123456789",
        ];

        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
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
            ]);
    }
}
