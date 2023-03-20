<?php

namespace App\Repositories;

use App\Interfaces\WpSiteRepositoryInterface;
use App\Models\WpSite;

class WpSiteRepository implements WpSiteRepositoryInterface 
{    
    /**
     * getAllWpSites
     *
     * @return mixed
     */
    public function getAllWpSites(){
        return  WpSite::paginate(10);
    }  

    /**
     * createWpSite
     *
     * @param  array $data
     * @return WpSite
     */
    public function createWpSite(array $data): WpSite{
        return WpSite::create($data);
    }
}