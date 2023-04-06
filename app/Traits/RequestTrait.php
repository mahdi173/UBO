<?php
namespace App\Traits;

trait RequestTrait {
    public function makeRequest(?string $token, string $method, string $url, array $param, int $status, ?array $structure=null, ?array $data=null) {
        if(!$token){
            if($method=="POST"){
                return $this->json($method, $url, $data, $param)
                ->assertStatus($status);
            }
        }

        if(!$structure){
            return $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json($method, $url, $param)
            ->assertStatus($status);
        }

        if(($method=="GET" || $method=="delete") && $structure){
            return $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json($method, $url, $param)
            ->assertStatus($status)
            ->assertJsonStructure($structure);
        }

        return $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json($method, $url, $data, $param)
            ->assertStatus($status)
            ->assertJsonStructure($structure);
    }
}