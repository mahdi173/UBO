<?php

namespace App\Repositories;

use App\Interfaces\RoleRepositoryInterface;
use App\Models\Role;

class RoleRepository implements RoleRepositoryInterface 
{    
    /**
     * getRoleByName
     *
     * @param  string $name
     * @return Role
     */
    public function getRoleByName(string $name): Role{
        return Role::where('name', $name)->first();
    }
}