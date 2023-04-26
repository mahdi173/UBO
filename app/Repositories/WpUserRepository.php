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
        $password= bcrypt("123456789");
        if(isset($data['password'])){
            $password= $data['password'];
        }

        return WpUser::create([
            'userName' => $data['email'],
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'email' => $data['email'],
            'password' => $password
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
    
    /**
     * getById
     *
     * @param  int $id
     * @return mixed
     */
    public function getById(int $id): mixed{
        return WpUser::with(['sites' => function ($query) {
            $query->select('wp_sites.*', 'roles', 'username');
        }])->find($id);
    }

    /**
     * getWpUserByEmail
     *
     * @param  string $email
     * @return WpUser
     */
    public function getWpUserByEmail(string $email): ?WpUser{
        return WpUser::where("email", $email)->first();
    }
}