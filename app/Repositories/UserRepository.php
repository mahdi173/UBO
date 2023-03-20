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

    public function createUser(array $data): User{
        return User::create($data);
    }

    public function getUserByEmail(string $email): User{
        return  User::where('email', $email)->first();
    }

    public function getUserById (int $userId): User{
        return User::findOrFail($userId);
    }
}
   