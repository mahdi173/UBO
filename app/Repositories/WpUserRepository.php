<?php

namespace App\Repositories;

use App\Enum\CronStateEnum;
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
        $username= $data['email'];
        if(isset($data['userName'])){
            $username= $data['userName'];
        }

        return WpUser::create([
            'userName' => $username,
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'email' => $data['email']
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
            $query->select('wp_sites.*', 'roles', 'username')->where("etat","!=", CronStateEnum::ToDelete->value);
        }])->find($id);
    }

    /**
     * getWpUserByEmail
     *
     * @param  string $email
     * @return WpUser
     */
    public function getWpUserByEmail(string $email): ?WpUser{
        return WpUser::withTrashed()->where("email", $email)->first();
    }

    /**
     * findById
     *
     * @param  int $id
     * @return mixed
     */
    public function findById(int $id): ?WpUser{
        return WpUser::where("id", $id)->first();
    }
}