<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\WpUser;
use Illuminate\Support\Facades\DB;

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
            'password' => bcrypt("123456789"),
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
        return WpUser::with(['sites'=> function($query){
            $query->select(DB::raw('DISTINCT(wp_sites.id), wp_sites.*'));
        }, "sites.roles"=> function($query) use ($id){
            $query->whereHas('users', function( $query)  use ($id){
                $query->where ('wp_user_id', $id);
    
            });
        }])->find($id);
    }
}