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
     * @param  mixed $wpSite
     * @param  array $data
     * @return void
     */
    public function update(mixed $wpSite, array $data): void {
      $wpSite->update($data);
    }
    
    /**
     * delete
     *
     * @param  mixed $wpSite
     * @return void
     */
    public function delete(mixed $wpSite): void{
        $wpSite->delete();
    }
}