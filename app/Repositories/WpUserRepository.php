<?php

namespace App\Repositories;

use App\Interfaces\WpUserRepositoryInterface;
use App\Models\WpUser;

class WpUserRepository implements WpUserRepositoryInterface 
{    
    /**
     * getAllWpUsers
     *
     * @return mixed
     */
    public function getAllWpUsers() {
        return WpUser::paginate(10);
    }    
    /**
     * createWpUser
     *
     * @param  array $data
     * @return WpUser
     */
    public function createWpUser(array $data): WpUser{
        return WpUser::create($data);
    }
}