<?php

namespace App\Repositories;

use App\Models\WpSite;
use App\Interfaces\CrudInterface;
use Illuminate\Http\JsonResponse;
use App\Interfaces\WpSiteRepositoryInterface;

class WpSiteRepository implements CrudInterface,WpSiteRepositoryInterface 
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
    public function showUsers(WpSite $site) :JsonResponse{
        $utilisateurs = $site->users()
        ->with(['roles' => function($query) {
            $query->select( 'wp_role_id','name');
        }])
        ->get();
         return response()->json($utilisateurs, 200);
    }
    


}