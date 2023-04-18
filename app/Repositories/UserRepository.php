<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Str;


class UserRepository implements UserRepositoryInterface, CrudInterface 
{    
    /**
     * getAll
     *
     * @return mixed
     */
    public function getAll(){
        return User::paginate(10);
    }
    
    /**
     * create
     *
     * @param  array $data
     * @return User
     */
    public function create(array $data): User{
        $roleId=1;
        if(isset($data['role_id'])){
            $roleId= $data['role_id'];
        }
        return User::create([
            'userName' => $data['userName'],
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'email' => $data['email'],
            'password' => bcrypt(Str::random(12)),
            'role_id'=> $roleId
        ]);
    }

    public function update(mixed $user, array $data){
    }

    public function delete(mixed $user){
    }
    
    /**
     * getUserByEmail
     *
     * @param  string $email
     * @return User
     */
    public function getUserByEmail(string $email): User|null {
        return  User::where('email', $email)->first();
    }
}
   