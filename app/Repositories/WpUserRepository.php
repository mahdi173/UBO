<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\WpUser;

class WpUserRepository implements CrudInterface 
{        
    /**
     * getAll
     *
     * @return mixed
     */
    public function getAll(): mixed{
        return WpUser::paginate(10);
    }
    
    /**
     * create
     *
     * @param  array $data
     * @return WpUser
     */
    public function create(array $data): WpUser {
        return WpUser::create([
            'userName' => $data['userName'],
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    
    /**
     * update
     *
     * @param  mixed $wpUser
     * @param  array $data
     * @return void
     */
    public function update(mixed $wpUser, array $data): void {
      $wpUser->update($data);
    }
      
    /**
     * delete
     *
     * @param  mixed $wpUser
     * @return void
     */
    public function delete(mixed $wpUser): void{
        $wpUser->delete();
    }
}