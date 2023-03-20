<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface 
{    
    /**
     * getAllUsers
     *
     * @return mixed
     */
    public function getAllUsers(){
        return User::paginate(10);
    }
    
    /**
     * createUser
     *
     * @param  array $data
     * @return User
     */
    public function createUser(array $data): User{
        return User::create($data);
    }
    
    /**
     * getUserByEmail
     *
     * @param  string $email
     * @return User
     */
    public function getUserByEmail(string $email): User{
        return  User::where('email', $email)->first();
    }
    
    /**
     * getUserById
     *
     * @param  int $userId
     * @return User
     */
    public function getUserById (int $userId): User{
        return User::findOrFail($userId);
    }
}
   