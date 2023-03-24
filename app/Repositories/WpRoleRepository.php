<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\WpRole;
use Illuminate\Database\Eloquent\Collection;

class WpRoleRepository implements CrudInterface 
{      
    /**
     * getAll
     *
     * @return Collection
     */
    public function getAll(): Collection{
        return WpRole::all();
    }
    
    /**
     * create
     *
     * @param  array $data
     * @return WpRole
     */
    public function create(array $data): WpRole {
        return  WpRole::create($data);
    }
    
    /**
     * update
     *
     * @param  mixed $wpRole
     * @param  array $data
     * @return void
     */
    public function update(mixed $wpRole, array $data): void {
      $wpRole->update($data);
    }
      
    /**
     * delete
     *
     * @param  mixed $wpRole
     * @return void
     */
    public function delete(mixed $wpRole): void{
        $wpRole->delete();
    }
}