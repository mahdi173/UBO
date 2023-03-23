<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\WpSite;

class WpSiteRepository implements CrudInterface 
{      
    /**
     * getAll
     *
     * @return mixed
     */
    public function getAll(): mixed{
        return  WpSite::paginate(10);
    }
    
    /**
     * create
     *
     * @param  array $data
     * @return WpSite
     */
    public function create(array $data): WpSite {
        return WpSite::create($data);
    }
    
    /**
     * update
     *
     * @param  mixed $item
     * @param  array $data
     * @return void
     */
    public function update(mixed $item, array $data): void {
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