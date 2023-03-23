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
     * @param  mixed $item
     * @param  array $data
     * @return void
     */
    public function update($item, array $data): void {
      $item->update($data);
    }
      
    /**
     * delete
     *
     * @param  mixed $item
     * @return void
     */
    public function delete(mixed $item): void{
        $item->delete();
    }
}