<?php

namespace App\Repositories;

use App\Interfaces\WpRoleRepositoryInterface;
use App\Models\WpRole;
use Illuminate\Database\Eloquent\Collection;

class WpRoleRepository implements WpRoleRepositoryInterface 
{    
    /**
     * getAllWpRoles
     *
     * @return Collection
     */
    public function getAllWpRoles(): Collection{
        return WpRole::all();
    }
    
    /**
     * createWpRole
     *
     * @param  string $name
     * @return WpRole
     */
    public function createWpRole(string $name): WpRole{
        return  WpRole::create([
            'name'=> $name
        ]);
    }
}